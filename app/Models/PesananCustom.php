<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananCustom extends Model
{
    use HasFactory;

    protected $table = 'pesanan_custom';
    protected $primaryKey = 'pesanan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pesanan_id',
        'user_id',
        'tanggal_pesanan',
        'ukuran_botol_ml',
        'alkohol_ml',
        'total_harga',
        'status_pesanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pesanan_id', 'pesanan_id');
    }

    public function komposisiAroma()
    {
        return $this->hasMany(KomposisiAroma::class, 'pesanan_id', 'pesanan_id');
    }
}