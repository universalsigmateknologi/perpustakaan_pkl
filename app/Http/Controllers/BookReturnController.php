<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\BookReturn;
use App\Models\Setting;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookReturnController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Hanya tampilkan transaksi yang sedang dipinjam
        $loans = Loan::with(['member', 'details.book', 'user'])
            ->where('status', 'dipinjam')
            ->when($search, function ($query) use ($search) {
                $query->where('kode_pinjam', 'like', "%{$search}%")
                      ->orWhereHas('member', function ($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode_member', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10);

        return view('main_menu.book_return.index', compact('loans'));
    }

    public function process(Request $request, Loan $loan)
    {
        // Pastikan transaksi belum dikembalikan
        if ($loan->status !== 'dipinjam') {
            return back()->with('error', 'Transaksi ini sudah dikembalikan sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $today = Carbon::now()->toDateString();
            $dueDate = Carbon::parse($loan->tanggal_kembali);
            
            // Hitung hari terlambat (jika tanggal hari ini > batas kembali)
            $lateDays = Carbon::now()->startOfDay()->gt($dueDate->startOfDay()) 
                        ? $dueDate->diffInDays(Carbon::now()->startOfDay()) 
                        : 0;

            // Ambil nominal denda dari settings
            $dendaPerHari = (int) Setting::where('key', 'denda_per_hari')->value('value');
            $totalDenda = $lateDays * $dendaPerHari;

            // 1. Buat Record Pengembalian di tabel 'returns'
            $lastReturn = BookReturn::latest('id')->first();
            $lastNum = $lastReturn ? (int) str_replace('KMB-', '', $lastReturn->kode_kembali) : 0;
            $kodeKembali = 'KMB-' . str_pad($lastNum + 1, 5, '0', STR_PAD_LEFT);

            BookReturn::create([
                'kode_kembali'   => $kodeKembali,
                'loan_id'        => $loan->id,
                'user_id'        => auth()->id(),
                'tanggal_kembali'=> $today,
                'terlambat_hari' => $lateDays,
                'denda'          => $totalDenda,
                'catatan'        => $request->input('catatan'),
            ]);

            // 2. Kembalikan stok buku (tambah stok 'tersedia')
            foreach ($loan->details as $detail) {
                $detail->book()->increment('tersedia');
            }

            // 3. Update status transaksi peminjaman
            $loan->update([
                'status'             => 'dikembalikan',
                'tanggal_dikembalikan' => $today
            ]);

            // 4. Catat denda jika terlambat
            if ($totalDenda > 0) {
                $lastFine = Fine::latest('id')->first();
                $lastFineNum = $lastFine ? (int) str_replace('DND-', '', $lastFine->kode_denda) : 0;
                $kodeDenda = 'DND-' . str_pad($lastFineNum + 1, 5, '0', STR_PAD_LEFT);

                Fine::create([
                    'kode_denda'  => $kodeDenda,
                    'member_id'   => $loan->member_id,
                    'loan_id'     => $loan->id,
                    'jumlah'      => $totalDenda,
                    'keterangan'  => "Denda keterlambatan pengembalian buku ($lateDays hari).",
                    'status'      => 'belum_bayar',
                ]);
            }

            DB::commit();

            $msg = "Buku berhasil dikembalikan.";
            if ($lateDays > 0) {
                $msg .= " Terlambat $lateDays hari. Denda sebesar Rp " . number_format($totalDenda, 0, ',', '.') . " telah dicatat.";
            }

            return redirect()->route('book_returns.index')->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}