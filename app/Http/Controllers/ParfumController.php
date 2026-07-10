<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulaAroma;
use App\Models\PesananCustom;
use App\Models\KomposisiAroma;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ParfumController extends Controller
{
    public function index()
    {
        $formulaAramas = FormulaAroma::all(); 
        return view('parfum.custom', compact('formulaAramas'));
    }

    public function store(Request $request)
    {
        // 1. Validasi: Pastikan data terkirim dengan benar
        $request->validate([
            'ukuran_botol' => 'required|in:30ml,50ml,100ml,200ml',
            'aroma_id'     => 'required|array|min:1', // Pastikan di Blade name="aroma_id[]"
            'takaran'      => 'required|array',
        ], [
            'aroma_id.required' => 'Pilih minimal satu aroma untuk parfum Anda.',
        ]);

        // Gunakan variabel yang konsisten
        $aromaIds = $request->aroma_id;
        $takarans = $request->takaran;

        $ukuran_ml = (int) filter_var($request->ukuran_botol, FILTER_SANITIZE_NUMBER_INT);
        $total_takaran_aroma = array_sum($takarans);
        
        $alkohol_ml = $ukuran_ml - $total_takaran_aroma;

        if ($alkohol_ml < 0) {
            return back()->withErrors(['error' => 'Total takaran aroma melebihi kapasitas botol!']);
        }

        // 2. Hitung Total Harga
        $total_harga = 0;
        foreach ($aromaIds as $index => $id) {
            $aroma = FormulaAroma::find($id);
            
            if ($aroma) {
                // Pastikan takaran indeks ini ada
                $takaran = $takarans[$index] ?? 0;
                $total_harga += ($aroma->harga_per_ml * $takaran);
            }
        }
        
        $total_harga += 15000; 

        // 3. Simpan Pesanan Custom
        $pesanan_id = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        PesananCustom::create([
            'pesanan_id'      => $pesanan_id,
            'user_id'         => Auth::id(), // Gunakan Auth::id() lebih singkat
            'tanggal_pesanan' => now(),
            'ukuran_botol_ml' => $request->ukuran_botol,
            'alkohol_ml'      => $alkohol_ml,
            'total_harga'     => $total_harga,
            'status_pesanan'  => 'Menunggu Pembayaran'
        ]);

        // 4. Simpan Komposisi Aroma
        foreach ($aromaIds as $index => $id) {
            $takaran = $takarans[$index] ?? 0;
            
            // Hanya simpan jika takaran > 0
            if ($takaran > 0) {
                KomposisiAroma::create([
                    'pesanan_id'   => $pesanan_id,
                    'formula_id'   => $id,
                    'urutan_aroma' => $index + 1,
                    'takaran_ml'   => $takaran
                ]);
            }
        }

        return redirect()->route('pembayaran.index', $pesanan_id)
                         ->with('success', 'Pesanan custom berhasil dibuat!');
    }
}