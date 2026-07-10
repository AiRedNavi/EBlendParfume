<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | E-Blend Parfume</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #F3F4F6; color: #1F2937; }
        .accent-purple { background-color: #FF6BD0; }
        .accent-pink { background-color: #FF6B86; }
        .text-purple { color: #FF6BD0; }
        .border-pink { border-color: #FF6B86; }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col justify-between">

    <header class="bg-white shadow-sm py-5 px-8 flex justify-between items-center border-b-4 border-purple">
        <a href="/" class="text-2xl font-bold tracking-wider text-black">E<span class="text-purple">-Blend Admin</span></a>
        
        <nav class="space-x-6 flex items-center">
            <span class="text-sm font-semibold text-gray-600">Halo, {{ Auth::user()->nama }} (🔑 Admin)</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-500 hover:text-red-600 transition">Keluar</button>
            </form>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12 flex-1 w-full space-y-8">
        
        <div class="flex justify-between items-center border-b border-gray-300 pb-3">
            <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Manajemen Pesanan Pelanggan</h2>
            <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">Total: {{ $semua_pesanan->count() }} Transaksi</span>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline font-medium">✨ {{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID Pesanan</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Detail Parfum</th>
                            <th class="px-6 py-4">Total Harga</th>
                            <th class="px-6 py-4">Status Saat Ini</th>
                            <th class="px-6 py-4 text-center">Aksi Operasional</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($semua_pesanan as $pesanan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-gray-600">
                                    {{ $pesanan->pesanan_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $pesanan->user->nama ?? 'User Terhapus' }}</div>
                                    <div class="text-xs text-gray-500">ID User: {{ $pesanan->user_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    Custom Botol ({{ $pesanan->ukuran_botol_ml }})
                                    <span class="block text-xs text-gray-400">Alkohol: {{ $pesanan->alkohol_ml }}ml</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">🔴 Menunggu Bayar</span>
                                    @elseif($pesanan->status_pesanan === 'Pembayaran Dikirim')
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">🔵 Perlu Cek Bukti</span>
                                    @elseif($pesanan->status_pesanan === 'Diproses')
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-800">🧪 Sedang Diracik</span>
                                    @elseif($pesanan->status_pesanan === 'Selesai')
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">🟢 Selesai</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800">⚪ {{ $pesanan->status_pesanan }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="inline-flex items-center gap-4">
                                        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->pesanan_id) }}" method="POST" class="inline-flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_pesanan" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg p-2 focus:ring-pink focus:border-pink">
                                                <option value="Menunggu Pembayaran" {{ $pesanan->status_pesanan == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                                <option value="Pembayaran Dikirim" {{ $pesanan->status_pesanan == 'Pembayaran Dikirim' ? 'selected' : '' }}>Pembayaran Dikirim</option>
                                                <option value="Pesanan Diproses" {{ $pesanan->status_pesanan == 'Pesanan Diproses' ? 'selected' : '' }}>Diproses (Racik)</option>
                                                <option value="Pesanan Selesai" {{ $pesanan->status_pesanan == 'Pesanan Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Dibatalkan" {{ $pesanan->status_pesanan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                            <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold text-xs py-2 px-3 rounded-lg transition shadow-sm">
                                                Simpan
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.pesanan.destroy', $pesanan->pesanan_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan {{ $pesanan->pesanan_id }} secara permanen? Tindakan ini tidak bisa dibatalkan!');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg border border-red-200 transition shadow-sm title='Hapus Pesanan'">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 font-medium">
                                    Belum ada data pesanan masuk dari pelanggan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="text-center py-6 text-xs text-gray-400 bg-white border-t border-gray-200">
        &copy; {{ date('Y') }} E-Blend Parfume Admin Panel.
    </footer>

</body>
</html>