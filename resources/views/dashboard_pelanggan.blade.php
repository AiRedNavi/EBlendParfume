<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan | E-Blend Parfume</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #FCF3EE; color: #000000; }
        .accent-purple { background-color: #FF6BD0; }
        .accent-pink { background-color: #FF6B86; }
        .text-purple { color: #FF6BD0; }
        .border-pink { border-color: #FF6B86; }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col justify-between">

    <header class="bg-white shadow-sm py-5 px-8 flex justify-between items-center border-b border-pink">
        <a href="/" class="text-2xl font-bold tracking-wider text-black">E<span class="text-purple">-Blend Parfume</span></a>
        
        <nav class="space-x-6 flex items-center">
            <a href="{{ route('parfum.custom') }}" class="text-sm font-semibold hover:text-[#FF6B86] transition">Racik Parfum</a>
            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-[#FF6B86] transition">Dashboard</a>
            
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-500 hover:text-red-600 transition">
                    Keluar
                </button>
            </form>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-12 flex-1 w-full space-y-10">
        
        <div class="border-b border-gray-200 pb-3">
            <h2 class="text-2xl font-extrabold text-black tracking-tight">Dashboard Pelanggan</h2>
        </div>

        <div class="bg-white p-8 md:p-10 rounded-2xl border-4 border-pink shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#FCF3EE] rounded-full -mr-8 -mt-8"></div>
            
            <div class="space-y-3 max-w-2xl relative z-10">
                <h3 class="text-3xl font-extrabold text-black">Selamat Datang, {{ Auth::user()->nama }}</h3>
                <p class="text-gray-600 text-base leading-relaxed">
                    Laboratorium parfum kustom online Anda siap digunakan. Silakan mulai menciptakan aroma khas yang mendefinisikan karakter unik Anda sendiri hari ini.
                </p>
            </div>
            <div class="shrink-0 w-full md:w-auto relative z-10">
                <a href="{{ route('parfum.custom') }}" class="inline-block text-center w-full md:w-auto text-white font-bold text-base py-3.5 px-6 rounded-xl shadow-md accent-purple hover:bg-[#FF6B86] transition duration-200">
                    Mulai Racik Sekarang &rarr;
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-2xl border-2 border-pink shadow-md">
                <span class="text-xs font-mono tracking-widest text-gray-400 uppercase block">Nomor Telepon</span>
                <p class="text-lg font-bold text-black mt-2">
                    {{ Auth::user()->no_hp ?? '-' }}
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border-2 border-pink shadow-md md:col-span-2">
                <span class="text-xs font-mono tracking-widest text-gray-400 uppercase block">Alamat Pengiriman Utama</span>
                <p class="text-lg font-bold text-black mt-2 leading-relaxed">
                    {{ Auth::user()->alamat ?? 'Belum mengatur alamat lengkap.' }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border-4 border-pink shadow-xl overflow-hidden">
            <div class="px-8 py-5 border-b-2 border-pink bg-gray-50 flex justify-between items-center">
                <h4 class="text-black font-extrabold text-lg tracking-tight">
                    Riwayat Pesanan Racikan Parfum
                </h4>
                <span class="text-xs font-mono px-3 py-1 bg-gray-200 text-gray-700 rounded-full font-bold">
                    Total: {{ $pesanan_user->count() }} Pesanan
                </span>
            </div>
            
            <div class="p-6 md:p-8">
                @forelse($pesanan_user as $pesanan)
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-5 mb-4 bg-white border-2 border-gray-100 rounded-xl shadow-sm hover:border-pink/50 transition duration-150 gap-4">
                        
                        <div class="space-y-1">
                            <span class="text-xs font-mono font-bold text-gray-400 block">{{ $pesanan->pesanan_id }}</span>
                            <h5 class="font-extrabold text-gray-800 text-base">
                                Custom Parfum Silhouette ({{ $pesanan->ukuran_botol_ml }})
                            </h5>
                            <p class="text-xs text-gray-500">
                                Dibuat pada: <span class="font-medium">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d F Y') }}</span>
                            </p>
                            <p class="text-sm font-bold text-[#FF6B86] pt-1">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex flex-col sm:items-end gap-3 w-full sm:w-auto">
                            @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-amber-100 text-amber-700 border border-amber-300 text-center">
                                    🔴 Menunggu Pembayaran
                                </span>
                                <a href="{{ route('pembayaran.index', $pesanan->pesanan_id) }}" class="inline-block text-center text-xs font-bold bg-[#FF6BD0] text-white px-4 py-2 rounded-lg shadow-sm hover:bg-[#FF6B86] transition text-nowrap">
                                    Bayar Sekarang &rarr;
                                </a>
                            @elseif($pesanan->status_pesanan === 'Pembayaran Dikirim')
                                <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-blue-100 text-blue-700 border border-blue-300 text-center">
                                    🔵 Pesanan Dikonfirmasi
                                </span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Diproses' || $pesanan->status_pesanan === 'Peracikan')
                                <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-purple-100 text-purple-700 border border-purple-300 text-center">
                                    🧪 Pesanan DiProses
                                </span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Selesai')
                                <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-green-100 text-green-700 border border-green-300 text-center">
                                    🟢 Selesai / Dikirim
                                </span>
                            @elseif($pesanan->status_pesanan === 'Dibatalkan')
                                <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-red-100 text-red-700 border border-red-300 text-center">
                                    ❌ Dibatalkan
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-gray-100 text-gray-700 border border-gray-300 text-center">
                                    {{ $pesanan->status_pesanan }}
                                </span>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="text-center max-w-sm mx-auto py-12">
                        <div class="w-20 h-28 bg-[#FCF3EE] rounded-xl border-2 border-[#FF6BD0] mx-auto mb-6 flex flex-col items-center justify-center p-3 shadow-inner">
                            <span class="text-[8px] font-mono tracking-widest text-gray-400 mb-1">E-BLEND</span>
                            <div class="w-8 h-0.5 bg-[#FF6B86]"></div>
                        </div>
                        
                        <h5 class="text-lg font-bold text-black tracking-tight">Belum ada parfum yang Anda racik</h5>
                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Aroma impian Anda belum terdaftar di sini. Silakan buat pesanan racikan pertama Anda terlebih dahulu.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

    <footer class="text-center py-8 text-sm text-gray-500 border-t border-gray-200">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

</body>
</html>