<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Book;
use App\Models\Setting;
use App\Models\Fine;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $loans = Loan::with(['member', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where('kode_pinjam', 'like', "%{$search}%")
                      ->orWhereHas('member', function ($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode_member', 'like', "%{$search}%");
                      });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('main_menu.loans.index', compact('loans'));
    }

    public function create(Request $request)
    {
        $member = null;
        $memberResults = collect();
        $books = collect();
        
        $maxBooks = Setting::where('key', 'maksimal_jumlah_buku')->value('value') ?? 3;

        // Pencarian Anggota
        if ($request->has('member_search')) {
            $memberResults = Member::where('nama', 'like', "%{$request->member_search}%")
                ->orWhere('kode_member', 'like', "%{$request->member_search}%")
                ->orWhere('nis_nip', 'like', "%{$request->member_search}%")
                ->limit(5)->get();
        }

        // Jika anggota dipilih
        if ($request->filled('member_id')) {
            $member = Member::findOrFail($request->member_id);

            // Validasi ketat di sisi server saat memilih anggota
            if ($member->status != 'aktif') {
                return redirect()->route('loans.create')->with('error', 'Anggota ini berstatus NONAKTIF. Tidak bisa meminjam.');
            }
            if (Fine::where('member_id', $member->id)->where('status', 'belum_bayar')->exists()) {
                return redirect()->route('loans.create')->with('error', 'Anggota ini memiliki denda BELUM LUNAS. Tidak bisa meminjam.');
            }

            // Pencarian Buku jika anggota sudah dipilih
            if ($request->has('book_search')) {
                $books = Book::where('tersedia', '>', 0)
                    ->where(function ($q) use ($request) {
                        $q->where('judul', 'like', "%{$request->book_search}%")
                          ->orWhere('kode_buku', 'like', "%{$request->book_search}%")
                          ->orWhere('isbn', 'like', "%{$request->book_search}%");
                    })->limit(5)->get();
            }
        }

        return view('main_menu.loans.create', compact('member', 'memberResults', 'books', 'maxBooks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'books'     => 'required|array|min:1',
            'books.*'   => 'exists:books,id',
            'catatan'   => 'nullable|string'
        ]);

        $member = Member::findOrFail($request->member_id);
        $settingsMaxBooks = (int) Setting::where('key', 'maksimal_jumlah_buku')->value('value');
        $settingsMaxHari = (int) Setting::where('key', 'maksimal_hari_pinjam')->value('value');

        // Double Validation (mencegah bypass dari frontend)
        if ($member->status != 'aktif') return back()->with('error', 'Anggota tidak aktif.')->withInput();
        if (Fine::where('member_id', $member->id)->where('status', 'belum_bayar')->exists()) return back()->with('error', 'Anggota memiliki denda.')->withInput();
        if (count($request->books) > $settingsMaxBooks) return back()->with('error', "Maksimal meminjam $settingsMaxBooks buku.")->withInput();

        DB::beginTransaction();
        try {
            $lastLoan = Loan::latest('id')->first();
            $lastNum = $lastLoan ? (int) str_replace('LPJ-', '', $lastLoan->kode_pinjam) : 0;
            $kodePinjam = 'LPJ-' . str_pad($lastNum + 1, 5, '0', STR_PAD_LEFT);

            $loan = Loan::create([
                'kode_pinjam'     => $kodePinjam,
                'member_id'       => $request->member_id,
                'user_id'         => auth()->id(),
                'tanggal_pinjam'  => now()->toDateString(),
                'tanggal_kembali' => now()->addDays($settingsMaxHari)->toDateString(),
                'status'          => 'dipinjam',
                'catatan'         => $request->catatan,
            ]);

            foreach ($request->books as $bookId) {
                $book = Book::where('id', $bookId)->where('tersedia', '>', 0)->lockForUpdate()->first();
                if (!$book) {
                    throw new \Exception("Stok buku dengan ID $bookId tidak tersedia.");
                }

                LoanDetail::create([
                    'loan_id' => $loan->id,
                    'book_id' => $bookId,
                    'jumlah'  => 1,
                    'kondisi' => 'baik',
                ]);

                $book->decrement('tersedia');
            }

            DB::commit();
            return redirect()->route('loans.index')->with('success', 'Transaksi peminjaman berhasil disimpan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses peminjaman: ' . $e->getMessage())->withInput();
        }
    }
}