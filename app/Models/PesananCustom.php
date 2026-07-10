<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananCustom extends Model
{
    // Pastikan nama tabelnya sudah benar jika kamu menggunakan nama custom
    protected $table = 'pesanan_custom'; 

    // TAMBAHKAN BARIS INI: Mengizinkan kolom-kolom berikut diisi secara massal
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'tanggal_pesanan',
        'ukuran_botol_ml',
        'alkohol_ml',
        'total_harga',
        'status_pesanan',
    ];
}