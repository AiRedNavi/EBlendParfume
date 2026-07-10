<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananCustom;

class AdminPesananController extends Controller
{
    // Menampilkan semua pesanan dari semua pelanggan
    public function index()
    {
        // Mengambil semua pesanan, diurutkan dari yang paling baru
        $semua_pesanan = PesananCustom::orderBy('created_at', 'desc')->get();

        return view('dashboard_admin', compact('semua_pesanan'));
    }

    // Mengubah status pesanan
    public function updateStatus(Request $request, $pesanan_id)
    {
        $request->validate([
            // Sesuaikan opsi di bawah ini dengan isi ENUM database Anda
            'status_pesanan' => 'required|in:Menunggu Pembayaran,Pembayaran Dikirim,Pesanan Diproses,Pesanan Selesai,Dibatalkan'
        ]);

        $pesanan = PesananCustom::findOrFail($pesanan_id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan
        ]);

        return back()->with('success', 'Status pesanan ' . $pesanan_id . ' berhasil diperbarui!');
    }
    // Menghapus pesanan secara permanen
    public function destroy($pesanan_id)
    {
        $pesanan = PesananCustom::findOrFail($pesanan_id);
        $pesanan->delete();

        return back()->with('success', 'Pesanan dengan ID ' . $pesanan_id . ' berhasil dihapus permanen!');
    }
    }