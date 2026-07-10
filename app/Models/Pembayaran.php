<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak jamak (optional)
    protected $table = 'pembayaran'; 
    protected $primaryKey = 'pembayaran_id'; // Sesuaikan dengan nama PK di migrasi Anda

    /**
     * Kolom yang diizinkan untuk pengisian massal (Mass Assignment)
     */
    protected $fillable = [
        'pesanan_id',       // Kolom pemicu error yang wajib ditambahkan
        'jumlah_bayar',     // Contoh kolom tambahan, sesuaikan dengan database Anda
        'bukti_pembayaran', // Contoh kolom bukti transfer foto/pdf
        'metode_bayar',
        'status_pembayaran'
    ];

    /**
     * Relasi Balik ke Pesanan Custom
     */
    public function pesananCustom()
    {
        return $this->belongsTo(PesananCustom::class, 'pesanan_id', 'pesanan_id');
    }
}