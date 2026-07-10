<?php

use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
        Route::get('/admin/dashboard', function () {
            return view('dashboard_admin');
        })->name('dashboard.admin');
        
        // Kamu bisa menambahkan rute manajemen stok parfum / pesanan masuk admin di sini nanti
    });

    /**
     * KELOMPOK HAK AKSES: PELANGGAN
     * Hanya bisa diakses oleh user dengan role 'pelanggan'
     */
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::get('/pelanggan/dashboard', function () {
            return view('dashboard_pelanggan');
        })->name('dashboard.pelanggan');
    });

    /**
     * FITUR TRANSAKSI & CUSTOM PARFUM
     * Terbuka untuk semua user yang sudah login (atau bisa dipindah ke grup pelanggan jika hanya untuk pembeli)
     */
    Route::get('/custom-parfum', [ParfumController::class, 'index'])->name('parfum.custom');
    // Route untuk menyimpan hasil racikan (POST)
    Route::post('/custom-parfum', [ParfumController::class, 'store'])->name('parfum.store');
    Route::get('/pembayaran/{pesanan_id}', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{pesanan_id}/proses', [PembayaranController::class, 'bayar'])->name('pembayaran.proses');
    
    /**
     * FITUR PENGATURAN PROFIL
     * Diaktifkan kembali dengan aman di bawah middleware auth bawaan
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';