<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeding Users
        DB::table('users')->insert([
            ['nama' => 'Administrator', 'email' => 'admin@eblendparfum.com', 'password' => Hash::make('admin123'), 'no_hp' => '081111111111', 'alamat' => 'Lhokseumawe', 'role' => 'admin'],
            ['nama' => 'Pegawai 1', 'email' => 'pegawai@eblendparfum.com', 'password' => Hash::make('pegawai123'), 'no_hp' => '082222222222', 'alamat' => 'Lhokseumawe', 'role' => 'pegawai'],
            ['nama' => 'Andi Pratama', 'email' => 'andi@eblendparfum.com', 'password' => Hash::make('123456'), 'no_hp' => '083333333333', 'alamat' => 'Banda Aceh', 'role' => 'pelanggan'],
        ]);

        // Seeding Formula Aroma
        DB::table('formula_aroma')->insert([
            ['nama_formula' => 'Lavender', 'kategori' => 'Floral', 'deskripsi' => 'Aroma bunga lavender', 'harga_per_ml' => 5000.00],
            ['nama_formula' => 'Vanilla', 'kategori' => 'Sweet', 'deskripsi' => 'Aroma vanilla', 'harga_per_ml' => 4500.00],
            ['nama_formula' => 'Ocean', 'kategori' => 'Fresh', 'deskripsi' => 'Aroma laut segar', 'harga_per_ml' => 4800.00],
            ['nama_formula' => 'Coffee', 'kategori' => 'Woody', 'deskripsi' => 'Aroma kopi', 'harga_per_ml' => 5500.00],
            ['nama_formula' => 'Musk', 'kategori' => 'Musk', 'deskripsi' => 'Aroma musk', 'harga_per_ml' => 6000.00],
            ['nama_formula' => 'Rose', 'kategori' => 'Floral', 'deskripsi' => 'Aroma mawar', 'harga_per_ml' => 5200.00],
            ['nama_formula' => 'Jasmine', 'kategori' => 'Floral', 'deskripsi' => 'Aroma melati', 'harga_per_ml' => 5100.00],
            ['nama_formula' => 'Lemon', 'kategori' => 'Fresh', 'deskripsi' => 'Aroma lemon', 'harga_per_ml' => 4700.00],
        ]);
    }
}