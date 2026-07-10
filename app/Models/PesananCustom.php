<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananCustom extends Model
{
    use HasFactory;

    protected $table = 'pesanan_custom';

    // 1. Beritahu Laravel bahwa Primary Key Anda adalah pesanan_id, BUKAN 'id'
    protected $primaryKey = 'pesanan_id';

    // 2. Beritahu Laravel bahwa Primary Key Anda berbentuk String (INV-xxxx), BUKAN Auto-Incrementing Integer
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pesanan_id',
        'user_id',
        'tanggal_pesanan',
        'ukuran_botol_ml',
        'alkohol_ml',
        'total_harga',
        'status_pesanan'
    ];
}