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
        Schema::create('pesanan_custom', function (Blueprint $table) {
            $table->string('pesanan_id', 20)->primary(); // Varchar 20 primary key
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_pesanan');
            $table->enum('ukuran_botol_ml', ['30ml', '50ml', '100ml', '200ml']);
            $table->decimal('alkohol_ml', 6, 2);
            $table->decimal('total_harga', 12, 2);
            $table->enum('status_pesanan', ['Menunggu Pembayaran', 'Pembayaran Dikirim', 'Pembayaran Valid', 'Pembayaran Tidak Valid', 'Pesanan Dikonfirmasi', 'Pesanan Diproses', 'Pesanan Selesai', 'Dibatalkan'])->default('Menunggu Pembayaran');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_customs');
    }
};
