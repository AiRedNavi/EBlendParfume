<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formula_aroma', function (Blueprint $table) {
            $table->id('formula_id');
            $table->string('nama_formula', 100);
            $table->string('kategori', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_per_ml', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula_aromas');
    }
};
