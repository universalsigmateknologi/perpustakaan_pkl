<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Fine;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    // Halaman Utama Laporan
    public function index()
    {
        return view('laporan.index');
    }

    // =======================================================
    // 1. LAPORAN DATA BUKU
    // =======================================================
    public function books()
    {
        $books = Book::with(['category', 'author'])->latest()->get();
        $totalStok = $books->sum('jumlah');
        $totalTersedia = $books->sum('tersedia');
        
        return view('laporan.books', compact('books', 'totalStok', 'totalTersedia'));
    }

    public function exportBooksPdf()
    {
        $books = Book::with(['category', 'author'])->latest()->get();
        $pdf = Pdf::loadView('laporan.pdf.books_pdf', compact('books'));
        return $pdf->download('laporan-data-buku-' . date('d-m-Y') . '.pdf');
    }

    public function exportBooksExcel()
    {
        $books = Book::with(['category', 'author'])->latest()->get();
        $filename = 'laporan-data-buku-' . date('d-m-Y') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($books) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode Buku', 'Judul', 'Kategori', 'Penulis', 'Tahun', 'Total Stok', 'Tersedia']);
            
            foreach ($books as $book) {
                fputcsv($file, [
                    $book->kode_buku,
                    $book->judul,
                    $book->category->nama_kategori ?? '-',
                    $book->author->nama_penulis ?? '-',
                    $book->tahun_terbit,
                    $book->jumlah,
                    $book->tersedia
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =======================================================
    // 2. LAPORAN TRANSAKSI PEMINJAMAN
    // =======================================================
    public function transactions(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $loans = Loan::with(['member', 'user', 'details.book'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('laporan.transactions', compact('loans', 'startDate', 'endDate'));
    }

    public function exportTransactionsPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        
        $loans = Loan::with(['member', 'user'])->whereBetween('tanggal_pinjam', [$startDate, $endDate])->latest()->get();
        $pdf = Pdf::loadView('laporan.pdf.transactions_pdf', compact('loans', 'startDate', 'endDate'));
        
        return $pdf->download('laporan-transaksi-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportTransactionsExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $loans = Loan::with(['member'])->whereBetween('tanggal_pinjam', [$startDate, $endDate])->latest()->get();
        
        $filename = 'laporan-transaksi-' . $startDate . '-sd-' . $endDate . '.csv';
        $headers = ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename"];

        $callback = function() use ($loans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode Pinjam', 'Anggota', 'Tanggal Pinjam', 'Batas Kembali', 'Tgl Dikembalikan', 'Status']);
            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->kode_pinjam,
                    $loan->member->nama,
                    $loan->tanggal_pinjam,
                    $loan->tanggal_kembali,
                    $loan->tanggal_dikembalikan ?? '-',
                    ucfirst($loan->status)
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =======================================================
    // 3. LAPORAN KEUANGAN DENDA
    // =======================================================
    public function fines(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $fines = Fine::with(['member', 'loan'])
            ->where('status', 'lunas')
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalPemasukan = $fines->sum('jumlah');

        return view('laporan.fines', compact('fines', 'totalPemasukan', 'startDate', 'endDate'));
    }

    public function exportFinesPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        
        $fines = Fine::with(['member'])->where('status', 'lunas')->whereBetween('tanggal_bayar', [$startDate, $endDate])->latest()->get();
        $totalPemasukan = $fines->sum('jumlah');
        
        $pdf = Pdf::loadView('laporan.pdf.fines_pdf', compact('fines', 'totalPemasukan', 'startDate', 'endDate'));
        return $pdf->download('laporan-denda-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportFinesExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $fines = Fine::with(['member'])->where('status', 'lunas')->whereBetween('tanggal_bayar', [$startDate, $endDate])->latest()->get();
        
        $filename = 'laporan-denda-' . $startDate . '-sd-' . $endDate . '.csv';
        $headers = ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$filename"];

        $callback = function() use ($fines) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode Denda', 'Anggota', 'Tanggal Bayar', 'Jumlah Denda']);
            foreach ($fines as $fine) {
                fputcsv($file, [
                    $fine->kode_denda,
                    $fine->member->nama,
                    $fine->tanggal_bayar,
                    $fine->jumlah
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}