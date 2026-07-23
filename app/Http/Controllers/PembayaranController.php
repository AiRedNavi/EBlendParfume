<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananCustom;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // Tampilkan Halaman Invoice & Form Upload Bukti
    public function index($pesanan_id)
    {
        // Eager load komposisi aroma beserta detail formulanya (nama, harga per ml)
        $pesanan = PesananCustom::with(['komposisiAroma.formulaAroma'])
                                ->where('pesanan_id', $pesanan_id)
                                ->where('user_id', Auth::user()->user_id)
                                ->firstOrFail();

        return view('pembayaran.index', compact('pesanan'));
    }

    // Proses Simpan Bukti Pembayaran
    public function bayar(Request $request, $pesanan_id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pesanan = PesananCustom::where('pesanan_id', $pesanan_id)->firstOrFail();

        // Upload file bukti pembayaran ke folder storage/app/public/bukti_bayar
        $path = $request->file('bukti_pembayaran')->store('bukti_bayar', 'public');

        // Simpan ke tabel pembayaran
        Pembayaran::create([
            'pesanan_id' => $pesanan->pesanan_id,
            'tanggal_bayar' => now(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_bayar' => $pesanan->total_harga,
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'Menunggu'
        ]);

        // Update status pesanan custom
        $pesanan->update([
            'status_pesanan' => 'Pembayaran Dikirim'
        ]);

        return redirect()->route('parfum.custom')->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu konfirmasi admin.');
    }
}