<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomposisiAroma extends Model
{
    protected $table = 'komposisi_aroma';

    // Amankan juga model komposisi aroma agar bisa disimpan sekaligus
    protected $fillable = [
        'pesanan_id',
        'formula_id',
        'urutan_aroma',
        'takaran_ml',
    ];
}