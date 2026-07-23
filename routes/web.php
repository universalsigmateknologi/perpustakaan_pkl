<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PublisherController;
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
        
        // Nantinya route master data admin akan ditaruh di sini
    });

    // Grup Route Khusus Petugas
    Route::middleware('role:petugas')->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
        
        // Nantinya route operasional petugas akan ditaruh di sini
    });

});