<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Fine;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk Admin
        $totalBooks = Book::sum('jumlah');
        $totalMembers = Member::count();
        $activeLoans = Loan::where('status', 'dipinjam')->count();
        $unpaidFines = Fine::where('status', 'belum_bayar')->sum('jumlah');

        // Aktivitas terakhir (5 transaksi terbaru)
        $recentLoans = Loan::with(['member', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('totalBooks', 'totalMembers', 'activeLoans', 'unpaidFines', 'recentLoans'));
    }
}