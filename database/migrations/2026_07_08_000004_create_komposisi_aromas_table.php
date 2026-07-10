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
        Schema::create('komposisi_aroma', function (Blueprint $table) {
            $table->id('komposisi_id');
            $table->string('pesanan_id', 20);
            $table->unsignedBigInteger('formula_id');
            $table->integer('urutan_aroma');
            $table->decimal('takaran_ml', 6, 2);
            $table->timestamps();

            $table->foreign('pesanan_id')->references('pesanan_id')->on('pesanan_custom')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('formula_id')->references('formula_id')->on('formula_aroma')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komposisi_aromas');
    }
};
