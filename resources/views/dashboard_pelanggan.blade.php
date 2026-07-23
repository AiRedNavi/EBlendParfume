<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan | E-Blend Parfume</title>
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
        .hairline-full { height: 1px; background: linear-gradient(90deg, var(--gold-light), rgba(180,146,76,0.15)); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .fade-up-1 { animation-delay: .05s; }
        .fade-up-2 { animation-delay: .15s; }
        .fade-up-3 { animation-delay: .25s; }

        .order-row { transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease; }
        .order-row:hover { transform: translateY(-3px); box-shadow: 0 18px 40px -18px rgba(180,146,76,0.35); border-color: var(--gold-light); }

        .status-chip {
            font-family: 'Manrope', sans-serif;
            letter-spacing: 0.06em;
        }

        .bottle-cap {
            background: linear-gradient(180deg, var(--gold-light) 0%, var(--gold) 60%, #96793a 100%);
        }
        .bottle-glass {
            background: linear-gradient(160deg, #ffffff 0%, var(--cream) 55%, #ffffff 100%);
        }

        @media (prefers-reduced-motion: reduce) {
            .fade-up, .order-row { animation: none !important; transition: none !important; }
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col justify-between grain-bg">

    <header class="bg-white/80 backdrop-blur-sm py-5 px-8 flex justify-between items-center border-b border-[#F1E4C8] sticky top-0 z-30">
        <a href="/" class="flex items-center gap-2 text-2xl font-display font-semibold tracking-wide text-black">
            E<span class="text-purple">-Blend</span>
            <span class="hidden sm:inline text-gold font-normal text-base tracking-[0.3em] uppercase ml-1">Parfume</span>
        </a>

        <nav class="space-x-8 flex items-center">
            <a href="{{ route('parfum.custom') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-[#FF6B86] transition">Racik Parfum</a>
            <a href="{{ url('/dashboard') }}" class="relative text-xs font-bold uppercase tracking-widest text-black pb-1">
                Dashboard
                <span class="absolute left-0 -bottom-1 w-full h-[2px] bg-gold"></span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition">
                    Keluar
                </button>
            </form>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-14 flex-1 w-full space-y-14">

        <div class="fade-up fade-up-1 flex items-center gap-4">
            <span class="hairline flex-1"></span>
            <span class="text-[11px] font-bold uppercase tracking-[0.35em] text-gold whitespace-nowrap">Ruang Anggota</span>
            <span class="hairline flex-1"></span>
        </div>

        {{-- ===================== HERO WELCOME ===================== --}}
        <section class="fade-up fade-up-2 bg-white rounded-[28px] border border-[#F1E4C8] shadow-[0_30px_60px_-30px_rgba(180,146,76,0.25)] flex flex-col md:flex-row items-stretch overflow-hidden relative">

            <div class="flex-1 p-10 md:p-14 flex flex-col justify-center space-y-6 relative z-10">
                <span class="text-[11px] font-bold uppercase tracking-[0.3em] text-gold">Selamat Datang Kembali</span>
                <h3 class="font-display text-4xl md:text-5xl font-semibold text-black leading-tight">
                    {{ Auth::user()->nama }}
                </h3>
                <p class="text-gray-600 text-base leading-relaxed max-w-md">
                    Laboratorium parfum kustom Anda siap digunakan. Racik aroma personal yang merepresentasikan karakter khas Anda sendiri.
                </p>
                <div class="pt-2">
                    <a href="{{ route('parfum.custom') }}" class="inline-flex items-center gap-2 text-white font-semibold text-sm tracking-wide py-3.5 px-7 rounded-full shadow-md accent-purple hover:bg-[#FF6B86] transition duration-300">
                        Mulai Racik Sekarang
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="flex-1 flex items-center justify-center bg-[#FCF3EE] p-10 md:p-14 relative overflow-hidden">
                <div class="absolute w-72 h-72 rounded-full bg-gold-soft/60 blur-3xl -top-10 -right-10"></div>
                <div class="absolute w-56 h-56 rounded-full bg-[#FF6BD0]/10 blur-3xl -bottom-8 -left-8"></div>

                <div class="w-56 h-80 relative z-10 flex flex-col items-center">
                    <div class="w-16 h-4 bottle-cap rounded-t-sm shadow-md"></div>
                    <div class="w-9 h-4 bg-[#e9e1d2] border-x border-[#d9cbb0]"></div>
                    <div class="w-full flex-1 bottle-glass rounded-b-2xl border border-gold-light/70 shadow-xl flex flex-col items-center justify-center relative overflow-hidden px-4">
                        <div class="absolute top-3 left-3 right-3 h-px bg-white/60"></div>
                        <span class="text-[9px] font-bold tracking-[0.4em] text-gold uppercase">E-Blend</span>
                        <span class="font-display text-lg font-semibold text-black mt-2 tracking-wide">Your Signature</span>
                        <span class="font-display italic text-sm text-gray-400 -mt-1">Scent</span>
                        <div class="w-10 h-px bg-gold-light mt-4"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== INFO SINGKAT ===================== --}}
        <section class="fade-up fade-up-3 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-7 rounded-2xl border border-[#F1E4C8] shadow-sm hover:shadow-md transition">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-gold block">Nomor Telepon</span>
                <p class="font-data text-xl text-black mt-2">
                    {{ Auth::user()->no_hp ?? '—' }}
                </p>
            </div>

            <div class="bg-white p-7 rounded-2xl border border-[#F1E4C8] shadow-sm hover:shadow-md transition md:col-span-2">
                <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-gold block">Alamat Pengiriman Utama</span>
                <p class="font-data text-xl text-black mt-2 leading-snug">
                    {{ Auth::user()->alamat ?? 'Belum mengatur alamat lengkap.' }}
                </p>
            </div>
        </section>

        {{-- ===================== RIWAYAT PESANAN ===================== --}}
        <section class="fade-up fade-up-3 bg-white rounded-[28px] border border-[#F1E4C8] shadow-[0_30px_60px_-35px_rgba(180,146,76,0.25)] overflow-hidden">

            <div class="px-8 md:px-12 py-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-[0.3em] text-gold block mb-1">Arsip Racikan</span>
                    <h4 class="font-display text-3xl font-semibold text-black tracking-tight">
                        Riwayat Pesanan
                    </h4>
                </div>
                <span class="text-[11px] font-bold uppercase tracking-widest px-4 py-2 bg-[#FCF3EE] text-gray-600 rounded-full border border-[#F1E4C8]">
                    {{ $pesanan_user->count() }} Pesanan
                </span>
            </div>

            <div class="hairline-full mx-8 md:mx-12"></div>

            <div class="p-6 md:p-10 space-y-4">
                @forelse($pesanan_user as $pesanan)
                    <div class="order-row flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 bg-white border border-[#F1E4C8] rounded-2xl gap-5">

                        <div class="flex items-start gap-4">
                            <div class="hidden sm:flex flex-col items-center pt-1">
                                <span class="w-2 h-2 rounded-full bg-gold"></span>
                                <span class="w-px flex-1 bg-[#F1E4C8] mt-2"></span>
                            </div>
                            <div class="space-y-1.5">
                                <span class="text-[11px] font-mono font-bold text-gold tracking-wider block">{{ $pesanan->pesanan_id }}</span>
                                <h5 class="font-data text-lg text-gray-900">
                                    Custom Parfum Silhouette <span class="text-gray-400 font-normal text-base">({{ $pesanan->ukuran_botol_ml }})</span>
                                </h5>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">
                                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d F Y') }}
                                </p>
                                <p class="font-data text-base font-semibold text-[#FF6B86] pt-1">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:items-end gap-3 w-full sm:w-auto">
                            @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                <span class="status-chip px-3.5 py-1.5 text-[11px] font-bold uppercase rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-center">
                                    Menunggu Pembayaran
                                </span>
                                <a href="{{ route('pembayaran.index', $pesanan->pesanan_id) }}" class="inline-block text-center text-xs font-bold uppercase tracking-wide bg-black text-white px-5 py-2.5 rounded-full shadow-sm hover:bg-gold transition text-nowrap">
                                    Bayar Sekarang &rarr;
                                </a>
                            @elseif($pesanan->status_pesanan === 'Pembayaran Dikirim')
                                <span class="status-chip px-3.5 py-1.5 text-[11px] font-bold uppercase rounded-full bg-blue-50 text-blue-700 border border-blue-200 text-center">
                                    Pesanan Dikonfirmasi
                                </span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Diproses' || $pesanan->status_pesanan === 'Peracikan')
                                <span class="status-chip px-3.5 py-1.5 text-[11px] font-bold uppercase rounded-full bg-purple-50 text-purple-700 border border-purple-200 text-center">
                                    Pesanan Diproses
                                </span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Selesai')
                                <span class="status-chip px-3.5 py-1.5 text-[11px] font-bold uppercase rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-center">
                                    Selesai / Dikirim
                                </span>
                            @elseif($pesanan->status_pesanan === 'Dibatalkan')
                                <span class="status-chip px-3.5 py-1.5 text-[11px] font-bold uppercase rounded-full bg-red-50 text-red-700 border border-red-200 text-center">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="status-chip px-3.5 py-1.5 text-[11px] font-bold uppercase rounded-full bg-gray-50 text-gray-700 border border-gray-200 text-center">
                                    {{ $pesanan->status_pesanan }}
                                </span>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="text-center max-w-sm mx-auto py-16">
                        <div class="w-20 h-28 mx-auto mb-6 relative flex flex-col items-center">
                            <div class="w-8 h-3 bottle-cap rounded-t-sm"></div>
                            <div class="w-full flex-1 bottle-glass rounded-b-xl border border-gold-light/60 shadow-inner flex flex-col items-center justify-center p-3">
                                <span class="text-[7px] font-bold tracking-[0.3em] text-gold uppercase mb-1">E-Blend</span>
                                <div class="w-8 h-px bg-gold-light"></div>
                            </div>
                        </div>

                        <h5 class="font-display text-2xl font-semibold text-black tracking-tight">Belum ada parfum yang diracik</h5>
                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Aroma impian Anda belum terdaftar di sini. Silakan buat pesanan racikan pertama Anda.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <footer class="text-center py-8 text-xs uppercase tracking-widest text-gray-400 border-t border-[#F1E4C8]">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

</body>
</html>