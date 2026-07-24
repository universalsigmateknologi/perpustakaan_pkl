<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShelfController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookReturnController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route Autentikasi
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Route yang butuh login
Route::middleware('auth')->group(function () {
    
    // Redirect otomatis berdasarkan role setelah login
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('petugas.dashboard');
    })->name('dashboard');

    // Route Manajemen Anggota (Bisa diakses Admin & Petugas)
    Route::resource('members', MemberController::class);

    // Route Peminjaman (Karena create butuh parameter GET, kita define manual atau gunakan resource)
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');

    Route::get('/book-returns', [BookReturnController::class, 'index'])->name('book_returns.index');
    Route::post('/book-returns/{loan}', [BookReturnController::class, 'process'])->name('book_returns.process');

    // Route Denda
    Route::get('/denda', [FineController::class, 'index'])->name('denda.index');
    Route::patch('/denda/{fine}/pay', [FineController::class, 'pay'])->name('denda.pay');

    // Grup Route Khusus Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        // Route Manajemen User (Resource Controller)
        Route::resource('users', UserController::class);
        // Route Master Kategori
        Route::resource('categories', CategoryController::class);

        // Route Master Rak & Etalase
        Route::resource('etalase', ShelfController::class);

        Route::resource('authors', AuthorController::class);
        Route::resource('publishers', PublisherController::class);

        Route::resource('books', BookController::class);
        
        // Route Laporan
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        
        // Laporan Buku
        Route::get('/reports/books', [ReportController::class, 'books'])->name('reports.books');
        Route::get('/reports/books/pdf', [ReportController::class, 'exportBooksPdf'])->name('reports.books.pdf');
        Route::get('/reports/books/excel', [ReportController::class, 'exportBooksExcel'])->name('reports.books.excel');
        
        // Laporan Transaksi
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/transactions/pdf', [ReportController::class, 'exportTransactionsPdf'])->name('reports.transactions.pdf');
        Route::get('/reports/transactions/excel', [ReportController::class, 'exportTransactionsExcel'])->name('reports.transactions.excel');
        
        // Laporan Denda
        Route::get('/reports/fines', [ReportController::class, 'fines'])->name('reports.fines');
        Route::get('/reports/fines/pdf', [ReportController::class, 'exportFinesPdf'])->name('reports.fines.pdf');
        Route::get('/reports/fines/excel', [ReportController::class, 'exportFinesExcel'])->name('reports.fines.excel');
    });

    // Grup Route Khusus Petugas
    Route::middleware('role:petugas')->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
        
        // Nantinya route operasional petugas akan ditaruh di sini
    });

});