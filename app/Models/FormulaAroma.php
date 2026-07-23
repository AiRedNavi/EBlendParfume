<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaAroma extends Model
{
    protected $table = 'formula_aroma';
    protected $primaryKey = 'formula_id';
    public $incrementing = true;

    protected $fillable = [
        'nama_formula',
        'kategori',
        'deskripsi',
        'harga_per_ml',
    ];
}