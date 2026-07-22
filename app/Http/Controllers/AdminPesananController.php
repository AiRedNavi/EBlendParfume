<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananCustom;
use App\Models\User;
use App\Models\FormulaAroma;

class AdminPesananController extends Controller
{
    // Menampilkan seluruh data dashboard admin (pesanan, customer, formula)
    public function index()
    {
        $semua_pesanan = PesananCustom::with(['user', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        $semua_customer = User::where('role', 'pelanggan')
            ->withCount('pesananCustom')
            ->orderBy('nama')
            ->get();

        $semua_formula = FormulaAroma::orderBy('nama_formula')->get();

        return view('dashboard_admin', compact('semua_pesanan', 'semua_customer', 'semua_formula'));
    }

    public function updateStatus(Request $request, $pesanan_id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:Menunggu Pembayaran,Pembayaran Dikirim,Pesanan Diproses,Pesanan Selesai,Dibatalkan'
        ]);

        $pesanan = PesananCustom::findOrFail($pesanan_id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan
        ]);

        return back()->with('success', 'Status pesanan ' . $pesanan_id . ' berhasil diperbarui!');
    }

    public function destroy($pesanan_id)
    {
        $pesanan = PesananCustom::findOrFail($pesanan_id);
        $pesanan->delete();

        return back()->with('success', 'Pesanan dengan ID ' . $pesanan_id . ' berhasil dihapus permanen!');
    }
}