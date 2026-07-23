<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Proyek CParfume</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #FCF3EE; color: #000000; }
        .accent-purple { background-color: #FF6BD0; }
        .accent-pink { background-color: #FF6B86; }
        .border-purple { border-color: #FF6BD0; }
    </style>
</head>
<body class="font-sans antialiased">

    <div class="max-w-2xl mx-auto my-12 p-8 bg-white rounded-xl shadow-md border border-purple">
        <h2 class="text-2xl font-bold mb-1 text-center text-black">Invoice Pesanan Custom</h2>
        <p class="text-sm text-center text-gray-500 mb-6">ID Pesanan: <span class="font-mono font-bold text-gray-800">{{ $pesanan->pesanan_id }}</span></p>

        {{-- Detail Formula Aroma yang Dipilih --}}
        <div class="mb-6">
            <h3 class="text-sm font-semibold uppercase tracking-wider mb-2 text-gray-700">Komposisi Aroma Racikan Anda</h3>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="text-left px-4 py-2">Formula</th>
                            <th class="text-center px-4 py-2">Takaran</th>
                            <th class="text-right px-4 py-2">Harga/ml</th>
                            <th class="text-right px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pesanan->komposisiAroma as $komposisi)
                            <tr>
                                <td class="px-4 py-2 font-semibold text-gray-800">
                                    {{ $komposisi->formulaAroma->nama_formula ?? 'Formula Terhapus' }}
                                </td>
                                <td class="px-4 py-2 text-center text-gray-600">{{ $komposisi->takaran_ml }} ml</td>
                                <td class="px-4 py-2 text-right text-gray-600">
                                    Rp {{ number_format($komposisi->formulaAroma->harga_per_ml ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-right font-bold text-gray-900">
                                    Rp {{ number_format(($komposisi->formulaAroma->harga_per_ml ?? 0) * $komposisi->takaran_ml, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400 text-xs">
                                    Tidak ada data komposisi aroma untuk pesanan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-[#FCF3EE] p-4 rounded-lg mb-6 border border-gray-200">
            <div class="flex justify-between py-1">
                <span class="text-gray-600">Ukuran Botol:</span>
                <span class="font-bold">{{ $pesanan->ukuran_botol_ml }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-gray-600">Campuran Alkohol:</span>
                <span class="font-bold">{{ $pesanan->alkohol_ml }} ml</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-gray-600">Biaya Botol Kaca Eksklusif:</span>
                <span class="font-bold">Rp 15.000</span>
            </div>
            <hr class="my-2 border-gray-300">
            <div class="flex justify-between py-1 text-lg font-bold text-black">
                <span>Total Tagihan:</span>
                <span class="text-[#FF6BD0]">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-sm font-semibold uppercase tracking-wider mb-2 text-gray-700">Metode Pembayaran Transfer</h3>
            <p class="text-sm text-gray-600 mb-2">Silakan transfer sesuai nominal di atas ke rekening berikut:</p>
            <div class="p-3 bg-gray-50 rounded border border-gray-200 font-mono text-sm">
                <strong>Bank Syariah Indonesia (BSI)</strong><br>
                Nomor Rekening: 7712345678<br>
                a.n. CParfume Official
            </div>
        </div>

        <form action="{{ route('pembayaran.proses', $pesanan->pesanan_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Metode Pembayaran</label>
                <select name="metode_pembayaran" class="w-full p-2 border rounded bg-[#FCF3EE] focus:border-[#FF6BD0] outline-none" required>
                    <option value="BSI Transfer">BSI Transfer</option>
                    <option value="DANA E-Wallet">DANA E-Wallet</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Transfer</label>
                <input type="file" name="bukti_pembayaran" class="w-full p-2 border rounded bg-white text-sm" accept="image/*" required>
                <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG (Maksimal 2MB)</p>
            </div>

            <button type="submit" class="w-full text-white font-bold py-3 px-6 rounded-lg shadow-md accent-pink hover:bg-[#FF6BD0] transition duration-200">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>

</body>
</html>