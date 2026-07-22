<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'pembayaran_id';

    protected $fillable = [
        'pesanan_id',
        'tanggal_bayar',
        'metode_pembayaran',
        'jumlah_bayar',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    public function pesananCustom()
    {
        return $this->belongsTo(PesananCustom::class, 'pesanan_id', 'pesanan_id');
    }
}