<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomposisiAroma extends Model
{
    protected $table = 'komposisi_aroma';
    protected $primaryKey = 'komposisi_id';

    protected $fillable = [
        'pesanan_id',
        'formula_id',
        'urutan_aroma',
        'takaran_ml',
    ];

    public function formulaAroma()
    {
        return $this->belongsTo(FormulaAroma::class, 'formula_id', 'formula_id');
    }
}