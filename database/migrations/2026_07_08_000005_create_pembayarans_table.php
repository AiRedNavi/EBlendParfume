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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->string('pesanan_id', 20);
            $table->date('tanggal_bayar')->nullable();
            $table->string('metode_pembayaran', 50)->nullable();
            $table->decimal('jumlah_bayar', 12, 2)->nullable();
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->enum('status_pembayaran', ['Menunggu', 'Valid', 'Tidak Valid'])->default('Menunggu');
            $table->timestamps();

            $table->foreign('pesanan_id')->references('pesanan_id')->on('pesanan_custom')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
