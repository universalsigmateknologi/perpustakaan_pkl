<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Fine;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk Petugas (Fokus ke operasional)
        $availableBooks = Books::sum('tersedia');
        $totalMembers = Member::where('status', 'aktif')->count();
        $activeLoans = Loan::where('status', 'dipinjam')->count();
        $unpaidFines = Fine::where('status', 'belum_bayar')->count();

        // Aktivitas terakhir (5 transaksi terbaru)
        $recentLoans = Loan::with(['member', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.petugas', compact('availableBooks', 'totalMembers', 'activeLoans', 'unpaidFines', 'recentLoans'));
    }
}