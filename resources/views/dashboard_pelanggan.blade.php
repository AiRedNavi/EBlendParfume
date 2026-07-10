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
            <div class="px-8 py-5 border-b-2 border-pink bg-gray-50">
                <h4 class="text-black font-extrabold text-lg tracking-tight">
                    Riwayat Pesanan Racikan Parfum
                </h4>
            </div>
            
            <div class="p-12">
                <div class="text-center max-w-sm mx-auto py-4">
                    <div class="w-20 h-28 bg-[#FCF3EE] rounded-xl border-2 border-purple mx-auto mb-6 flex flex-col items-center justify-center p-3 shadow-inner">
                        <span class="text-[8px] font-mono tracking-widest text-gray-400 mb-1">E-BLEND</span>
                        <div class="w-8 h-0.5 bg-[#FF6B86]"></div>
                    </div>
                    
                    <h5 class="text-lg font-bold text-black tracking-tight">Belum ada parfum yang Anda racik</h5>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                        Aroma impian Anda belum terdaftar di sini. Silakan buat pesanan racikan pertama Anda terlebih dahulu.
                    </p>
                </div>
            </div>
        </div>

    </main>

    <footer class="text-center py-8 text-sm text-gray-500 border-t border-gray-200">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

</body>
</html>