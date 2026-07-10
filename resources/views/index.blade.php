<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Blend Parfume | Rasakan Aroma Custom Impianmu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #FCF3EE; color: #000000; }
        .accent-purple { background-color: #FF6BD0; }
        .accent-pink { background-color: #FF6B86; }
        .text-purple { color: #FF6BD0; }
        .border-pink { border-color: #FF6B86; }
    </style>
</head>
<body class="font-sans antialiased">

    <header class="bg-white shadow-sm py-5 px-8 flex justify-between items-center border-b border-pink">
        <a href="/" class="text-2xl font-bold tracking-wider text-black">E<span class="text-purple">-Blend Parfume</span></a>
        
        <nav class="space-x-6 flex items-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('parfum.custom') }}" class="text-sm font-semibold hover:text-[#FF6B86] transition">Racik Parfum</a>
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold hover:text-[#FF6B86] transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-[#FF6B86] transition">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white text-sm font-bold py-2 px-4 rounded-lg accent-pink hover:bg-[#FF6BD0] transition">Daftar Akun</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="flex-1 space-y-6 text-center md:text-left">
            <h1 class="text-4xl md:text-6xl font-extrabold text-black leading-tight">
                Ekspresikan Dirimu Lewat <br>
                <span class="text-purple">Aroma Custom</span> Anda.
            </h1>
            <p class="text-gray-600 text-lg max-w-md mx-auto md:mx-0">
                Sistem kustomisasi parfum online pertama yang membebaskanmu memilih ukuran botol dan takaran aroma favoritmu sendiri.
            </p>
            <div class="pt-4">
                @auth
                    <a href="{{ route('parfum.custom') }}" class="inline-block text-white font-bold text-lg py-4 px-8 rounded-xl shadow-md accent-purple hover:bg-[#FF6B86] transition duration-200">
                        Mulai Racik Sekarang &rarr;
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block text-white font-bold text-lg py-4 px-8 rounded-xl shadow-md accent-purple hover:bg-[#FF6B86] transition duration-200">
                        Buat Akun & Mulai Racik &rarr;
                    </a>
                @endauth
            </div>
        </div>

        <div class="flex-1 flex justify-center">
            <div class="w-72 h-96 bg-white rounded-2xl border-4 border-pink shadow-xl flex flex-col items-center justify-center p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-[#FCF3EE] rounded-full -mr-8 -mt-8"></div>
                <div class="w-24 h-8 bg-gray-200 rounded-t-md mb-1 border border-gray-400"></div>
                <div class="w-40 h-52 bg-[#FCF3EE] rounded-b-xl border-2 border-purple flex flex-col items-center justify-center shadow-inner">
                    <span class="text-xs font-mono tracking-widest text-gray-400 mb-2">E-BLEND</span>
                    <span class="text-sm font-bold tracking-wider text-black">YOUR SCENT</span>
                    <div class="w-12 h-0.5 bg-[#FF6B86] mt-2"></div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-8 text-sm text-gray-500 border-t border-gray-200 mt-12">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

</body>
</html>