<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaAroma extends Model
{
    // Tambahkan baris ini untuk mengunci nama tabel agar mengarah ke formula_aroma
    protected $table = 'formula_aroma';

    // Jika kamu punya primary key kustom (misal bukan 'id'), bisa sekalian disetel di sini
    protected $primaryKey = 'formula_id'; 
    public $incrementing = true;
}