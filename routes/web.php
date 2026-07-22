<?php

use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\PesananCustom;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\AdminFormulaController;

// 1. Halaman Landing Page Utama
Route::get('/', function () {
    return view('index');
});

// 2. Rute Autentikasi Utama (Membungkus Dashboard & Fitur Aplikasi)
Route::middleware(['auth', 'verified'])->group(function () {
    
    /**
     * PENGALIHAN DASHBOARD OTOMATIS (Berdasarkan Role Akun)
     * Jika mengetik /dashboard, sistem akan memeriksa role di database
     */
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'pelanggan') {
            return redirect()->route('dashboard.pelanggan');
        }
        return redirect()->route('dashboard.admin');
    })->name('dashboard');

    /**
     * KELOMPOK HAK AKSES: ADMIN & PEGAWAI
     * Hanya bisa diakses oleh user dengan role 'admin' atau 'pegawai'
     */
    Route::middleware(['role:admin,pegawai'])->group(function () {
    // Menampilkan Dashboard Admin dengan Data Pesanan
    Route::get('/admin/dashboard', [AdminPesananController::class, 'index'])->name('dashboard.admin');
    // ... di dalam Route::middleware(['role:admin,pegawai'])->group(function () { ... }
    Route::post('/admin/formula', [AdminFormulaController::class, 'store'])->name('admin.formula.store');
    Route::patch('/admin/formula/{formula_id}', [AdminFormulaController::class, 'update'])->name('admin.formula.update');
    Route::delete('/admin/formula/{formula_id}', [AdminFormulaController::class, 'destroy'])->name('admin.formula.destroy');
        // Route Proses Mengubah Status Pesanan
    Route::patch('/admin/pesanan/{pesanan_id}/status', [AdminPesananController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');
    Route::delete('/admin/pesanan/{pesanan_id}', [AdminPesananController::class, 'destroy'])->name('admin.pesanan.destroy');
    });

    /**
     * KELOMPOK HAK AKSES: PELANGGAN
     * Hanya bisa diakses oleh user dengan role 'pelanggan'
     */
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::get('/pelanggan/dashboard', function () {
            // PERBAIKAN: Ambil data pesanan kustom milik pelanggan yang sedang login saat ini
            $pesanan_user = PesananCustom::where('user_id', Auth::id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();

            // Kirim variabel $pesanan_user ke file blade dashboard_pelanggan
            return view('dashboard_pelanggan', compact('pesanan_user'));
        })->name('dashboard.pelanggan');
    });

    /**
     * FITUR TRANSAKSI & CUSTOM PARFUM
     * Terbuka untuk semua user yang sudah login
     */
    Route::get('/custom-parfum', [ParfumController::class, 'index'])->name('parfum.custom');
    Route::post('/custom-parfum', [ParfumController::class, 'store'])->name('parfum.store');
    Route::get('/pembayaran/{pesanan_id}', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{pesanan_id}/proses', [PembayaranController::class, 'bayar'])->name('pembayaran.proses');
    
    /**
     * FITUR PENGATURAN PROFIL
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';