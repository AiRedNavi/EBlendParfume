<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulaAroma;

class AdminFormulaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_formula' => 'required|string|max:100',
            'kategori'     => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'harga_per_ml' => 'required|numeric|min:0',
        ]);

        FormulaAroma::create($request->only([
            'nama_formula', 'kategori', 'deskripsi', 'harga_per_ml'
        ]));

        return back()->with('success', 'Formula aroma "' . $request->nama_formula . '" berhasil ditambahkan!');
    }

    public function update(Request $request, $formula_id)
    {
        $request->validate([
            'nama_formula' => 'required|string|max:100',
            'kategori'     => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'harga_per_ml' => 'required|numeric|min:0',
        ]);

        $formula = FormulaAroma::findOrFail($formula_id);
        $formula->update($request->only([
            'nama_formula', 'kategori', 'deskripsi', 'harga_per_ml'
        ]));

        return back()->with('success', 'Formula aroma berhasil diperbarui!');
    }

    public function destroy($formula_id)
    {
        $formula = FormulaAroma::findOrFail($formula_id);
        $formula->delete();

        return back()->with('success', 'Formula aroma berhasil dihapus!');
    }
}