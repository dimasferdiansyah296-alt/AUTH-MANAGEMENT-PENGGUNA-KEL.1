<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK (tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Middleware 'guest' = hanya bisa diakses oleh user yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| ROUTE YANG PERLU LOGIN (auth) + ROLE
|--------------------------------------------------------------------------
| Semua route di bawah ini membutuhkan user yang sudah login (middleware auth),
| kemudian dibatasi per-role oleh middleware 'role'.
*/
Route::middleware('auth')->group(function () {

    // Logout (bisa diakses semua role yang sudah login)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route umum /dashboard → redirect ke dashboard sesuai role user yang login
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'karyawan' => redirect()->route('karyawan.dashboard'),
            'pelanggan'=> redirect()->route('pelanggan.dashboard'),
            default    => redirect()->route('login'),
        };
    })->name('dashboard');

    // --- DASHBOARD ADMIN ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    });

    // --- DASHBOARD KARYAWAN (admin juga bisa akses karena admin adalah super role) ---
    Route::middleware('role:admin,karyawan')->group(function () {
        Route::get('/karyawan/dashboard', [DashboardController::class, 'karyawan'])->name('karyawan.dashboard');
    });

    // --- DASHBOARD PELANGGAN ---
    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/pelanggan/dashboard', [DashboardController::class, 'pelanggan'])->name('pelanggan.dashboard');

        // --- FITUR PEMESANAN (PELANGGAN) ---
        Route::prefix('pelanggan/pesanan')->name('pelanggan.pesanan.')->group(function () {
            Route::get('/', [PesananController::class, 'index'])->name('index');
            Route::get('/buat', [PesananController::class, 'create'])->name('create');
            Route::post('/', [PesananController::class, 'store'])->name('store');
            Route::get('/{pesanan}', [PesananController::class, 'show'])->name('show');
            Route::delete('/{pesanan}', [PesananController::class, 'destroy'])->name('destroy');
        });
    });

    // --- MANAJEMEN PESANAN (ADMIN & KARYAWAN) ---
    Route::middleware('role:admin,karyawan')->group(function () {
        Route::prefix('pesanan')->name('admin.pesanan.')->group(function () {
            Route::get('/', [PesananController::class, 'adminIndex'])->name('index');
            Route::get('/{pesanan}', [PesananController::class, 'adminShow'])->name('show');
            Route::get('/{pesanan}/edit', [PesananController::class, 'edit'])->name('edit');
            Route::put('/{pesanan}', [PesananController::class, 'update'])->name('update');
        });
    });
});
