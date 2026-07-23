<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Blend Parfume | Rasakan Aroma Custom Impianmu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,500&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #FCF3EE;
            --purple: #FF6BD0;
            --pink: #FF6B86;
            --ink: #000000;
            --gold: #B4924C;
            --gold-light: #D9BE87;
            --gold-soft: #F1E4C8;
        }
        body { background-color: var(--cream); color: var(--ink); font-family: 'Manrope', sans-serif; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-data { font-family: 'Lora', serif; font-weight: 500; letter-spacing: 0.01em; }
        .accent-purple { background-color: var(--purple); }
        .accent-pink { background-color: var(--pink); }
        .text-purple { color: var(--purple); }
        .border-pink { border-color: var(--pink); }
        .text-gold { color: var(--gold); }
        .border-gold { border-color: var(--gold); }
        .bg-gold { background-color: var(--gold); }
        .bg-gold-soft { background-color: var(--gold-soft); }

        .grain-bg {
            background-image: radial-gradient(circle at 15% 10%, rgba(255,107,208,0.07), transparent 40%),
                               radial-gradient(circle at 85% 0%, rgba(180,146,76,0.10), transparent 45%),
                               radial-gradient(circle at 90% 90%, rgba(255,107,134,0.06), transparent 40%);
        }

        .hairline { height: 1px; background: linear-gradient(90deg, transparent, var(--gold-light), transparent); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .fade-up-1 { animation-delay: .05s; }
        .fade-up-2 { animation-delay: .15s; }
        .fade-up-3 { animation-delay: .25s; }

        .bottle-cap {
            background: linear-gradient(180deg, var(--gold-light) 0%, var(--gold) 60%, #96793a 100%);
        }
        .bottle-glass {
            background: linear-gradient(160deg, #ffffff 0%, var(--cream) 55%, #ffffff 100%);
        }

        .feature-card { transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease; }
        .feature-card:hover { transform: translateY(-3px); box-shadow: 0 18px 40px -18px rgba(180,146,76,0.35); border-color: var(--gold-light); }

        @media (prefers-reduced-motion: reduce) {
            .fade-up, .feature-card { animation: none !important; transition: none !important; }
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col justify-between grain-bg">

    <header class="bg-white/80 backdrop-blur-sm py-5 px-8 flex justify-between items-center border-b border-[#F1E4C8] sticky top-0 z-30">
        <a href="/" class="flex items-center gap-2 text-2xl font-display font-semibold tracking-wide text-black">
            E<span class="text-purple">-Blend</span>
            <span class="hidden sm:inline text-gold font-normal text-base tracking-[0.3em] uppercase ml-1">Parfume</span>
        </a>

        <nav class="space-x-6 md:space-x-8 flex items-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('parfum.custom') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-[#FF6B86] transition">Racik Parfum</a>
                    <a href="{{ url('/dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-[#FF6B86] transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-[#FF6B86] transition">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white text-xs font-bold uppercase tracking-widest py-3 px-5 rounded-full shadow-sm accent-pink hover:bg-[#FF6BD0] transition">Daftar Akun</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-16 md:py-20 flex-1 w-full space-y-16">

        <div class="fade-up fade-up-1 flex items-center gap-4">
            <span class="hairline flex-1"></span>
            <span class="text-[11px] font-bold uppercase tracking-[0.35em] text-gold whitespace-nowrap">Kustomisasi Aroma Personal</span>
            <span class="hairline flex-1"></span>
        </div>

        <section class="fade-up fade-up-2 flex flex-col md:flex-row items-center justify-between gap-14">
            <div class="flex-1 space-y-7 text-center md:text-left">
                <h1 class="font-display text-5xl md:text-6xl font-semibold text-black leading-tight">
                    Ekspresikan Dirimu Lewat
                    <span class="text-purple italic">Aroma Custom</span> Anda.
                </h1>
                <p class="text-gray-600 text-lg leading-relaxed max-w-md mx-auto md:mx-0">
                    Sistem kustomisasi parfum online pertama yang membebaskanmu memilih ukuran botol dan takaran aroma favoritmu sendiri.
                </p>
                <div class="pt-4">
                    @auth
                        <a href="{{ route('parfum.custom') }}" class="inline-flex items-center gap-2 text-white font-semibold text-sm tracking-wide py-4 px-8 rounded-full shadow-md accent-purple hover:bg-[#FF6B86] transition duration-300">
                            Mulai Racik Sekarang
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-white font-semibold text-sm tracking-wide py-4 px-8 rounded-full shadow-md accent-purple hover:bg-[#FF6B86] transition duration-300">
                            Buat Akun & Mulai Racik
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endauth
                </div>
            </div>

            <div class="flex-1 flex justify-center relative">
                <div class="absolute w-72 h-72 rounded-full bg-gold-soft/60 blur-3xl -top-10 -right-6"></div>
                <div class="absolute w-56 h-56 rounded-full bg-[#FF6BD0]/10 blur-3xl -bottom-8 -left-8"></div>

                <div class="w-72 h-96 bg-white rounded-[28px] border border-[#F1E4C8] shadow-[0_30px_60px_-30px_rgba(180,146,76,0.25)] flex flex-col items-center justify-center p-8 relative overflow-hidden z-10">
                    <div class="w-16 h-4 bottle-cap rounded-t-sm shadow-md"></div>
                    <div class="w-9 h-4 bg-[#e9e1d2] border-x border-[#d9cbb0]"></div>
                    <div class="w-44 flex-1 bottle-glass rounded-b-2xl border border-gold-light/70 shadow-inner flex flex-col items-center justify-center relative overflow-hidden px-4">
                        <div class="absolute top-3 left-3 right-3 h-px bg-white/60"></div>
                        <span class="text-[9px] font-bold tracking-[0.4em] text-gold uppercase">E-Blend</span>
                        <span class="font-display text-lg font-semibold text-black mt-2 tracking-wide">Your Signature</span>
                        <span class="font-display italic text-sm text-gray-400 -mt-1">Scent</span>
                        <div class="w-10 h-px bg-gold-light mt-4"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fade-up fade-up-3 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="feature-card bg-white p-8 rounded-2xl border border-[#F1E4C8] shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-gold block mb-3">Pilih Sendiri</span>
                <h3 class="font-display text-2xl font-semibold text-black">Ukuran Botol</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Tentukan volume yang sesuai dengan gaya dan kebutuhanmu sehari-hari.</p>
            </div>
            <div class="feature-card bg-white p-8 rounded-2xl border border-[#F1E4C8] shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-gold block mb-3">Racikan Personal</span>
                <h3 class="font-display text-2xl font-semibold text-black">Takaran Aroma</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Sesuaikan komposisi wewangian favorit hingga menjadi signature scent-mu.</p>
            </div>
            <div class="feature-card bg-white p-8 rounded-2xl border border-[#F1E4C8] shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-gold block mb-3">Kualitas Terjaga</span>
                <h3 class="font-display text-2xl font-semibold text-black">Bahan Premium</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Diracik dari bahan pilihan untuk aroma yang tahan lama dan elegan.</p>
            </div>
        </section>

    </main>

    <footer class="text-center py-8 text-xs uppercase tracking-widest text-gray-400 border-t border-[#F1E4C8]">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

</body>
</html>