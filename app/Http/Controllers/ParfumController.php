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
        // Perbaikan typo penamaan variabel agar bersih
        $formulaAroma = FormulaAroma::all(); 
        return view('parfum.custom', compact('formulaAroma'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Form secara Ketat
        $request->validate([
            'ukuran_botol' => 'required|in:30ml,50ml,100ml,200ml',
            'aroma_id'     => 'required|array|min:1', 
            'takaran'      => 'required|array',
        ], [
            'aroma_id.required' => 'Pilih minimal satu aroma untuk parfum Anda.',
        ]);

        $aromaIds = $request->aroma_id;
        $takarans = $request->takaran;

        // 2. Ekstrak Kapasitas Botol Murni (Angka)
        $ukuran_ml = (int) filter_var($request->ukuran_botol, FILTER_SANITIZE_NUMBER_INT);
        
        // Fallback jika pembersihan filter_var menghasilkan angka 0
        if ($ukuran_ml === 0) {
            $ukuran_ml = match($request->ukuran_botol) {
                '30ml'  => 30,
                '50ml'  => 50,
                '100ml' => 100,
                '200ml' => 200,
                default => 30
            };
        }

        // 3. OPTIMALISASI: Hitung Total Takaran Aroma HANYA dari Aroma yang Dipilih Pelanggan
        $total_takaran_aroma = 0;
        foreach ($aromaIds as $id) {
            // Mengambil takaran berdasarkan ID aroma sebagai key (Mencegah desinkronisasi indeks array)
            $total_takaran_aroma += (int) ($takarans[$id] ?? 0);
        }
        
        // 4. Kalkulasi Sisa Kapasitas untuk Alkohol Murni
        $alkohol_ml = $ukuran_ml - $total_takaran_aroma;

        if ($alkohol_ml < 0) {
            return back()->withErrors(['error' => 'Total takaran esens aroma melebihi kapasitas volume botol!'])->withInput();
        }

        // 5. Hitung Total Harga Berdasarkan Nilai Database
        $total_harga = 0;
        foreach ($aromaIds as $id) {
            $takaran_spesifik = (int) ($takarans[$id] ?? 0);
            
            if ($takaran_spesifik > 0) {
                $aroma = FormulaAroma::find($id);
                if ($aroma) {
                    $total_harga += ($aroma->harga_per_ml * $takaran_spesifik);
                }
            }
        }
        
        $total_harga += 15000; // Biaya flat botol kaca eksklusif

        // 6. Buat Kode Invoice Unik
        $pesanan_id = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // 7. Simpan Data Utama Pesanan Custom
        PesananCustom::create([
            'pesanan_id'      => $pesanan_id,
            'user_id'         => Auth::id(), 
            'tanggal_pesanan' => now(),
            'ukuran_botol_ml' => $request->ukuran_botol,
            'alkohol_ml'      => $alkohol_ml, // Sekarang nilainya akurat dan dinamis!
            'total_harga'     => $total_harga,
            'status_pesanan'  => 'Menunggu Pembayaran'
        ]);

        // 8. Simpan Detail Komposisi Esens Aroma Racikan
        $urutan = 1;
        foreach ($aromaIds as $id) {
            $takaran = (int) ($takarans[$id] ?? 0);
            
            if ($takaran > 0) {
                KomposisiAroma::create([
                    'pesanan_id'   => $pesanan_id,
                    'formula_id'   => $id,
                    'urutan_aroma' => $urutan++,
                    'takaran_ml'   => $takaran
                ]);
            }
        }

        return redirect()->route('pembayaran.index', $pesanan_id)
                         ->with('success', 'Pesanan custom berhasil dibuat!');
    }
}