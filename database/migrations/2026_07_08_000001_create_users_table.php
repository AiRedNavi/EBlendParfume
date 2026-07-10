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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); 
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable(); // <-- Tambahkan baris ini
            $table->string('password');
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('role', ['pelanggan', 'admin', 'pegawai'])->default('pelanggan');
            $table->rememberToken(); // <-- Pastikan ini juga ada jika menggunakan Breeze
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
