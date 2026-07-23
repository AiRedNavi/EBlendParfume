<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun | E-Blend Parfume</title>
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

        .input-field {
            width: 100%;
            margin-top: 0.375rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #F1E4C8;
            outline: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: border-color .25s ease, box-shadow .25s ease;
            background-color: #fff;
        }
        .input-field:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(180,146,76,0.12); }

        @media (prefers-reduced-motion: reduce) {
            .fade-up { animation: none !important; }
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col justify-between grain-bg">

    <header class="bg-white/80 backdrop-blur-sm py-5 px-8 flex justify-between items-center border-b border-[#F1E4C8] sticky top-0 z-30">
        <a href="/" class="flex items-center gap-2 text-2xl font-display font-semibold tracking-wide text-black">
            E<span class="text-purple">-Blend</span>
            <span class="hidden sm:inline text-gold font-normal text-base tracking-[0.3em] uppercase ml-1">Parfume</span>
        </a>
        <nav class="space-x-6">
            <a href="{{ route('register') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-[#FF6B86] transition">Daftar Akun</a>
        </nav>
    </header>

    <main class="flex-1 flex items-center justify-center px-6 py-16">
        <div class="fade-up w-full max-w-md bg-white p-8 md:p-10 rounded-[28px] border border-[#F1E4C8] shadow-[0_30px_60px_-30px_rgba(180,146,76,0.25)] relative overflow-hidden">
            <div class="absolute w-56 h-56 rounded-full bg-gold-soft/60 blur-3xl -top-14 -right-14 z-0"></div>
            <div class="absolute w-40 h-40 rounded-full bg-[#FF6BD0]/10 blur-3xl -bottom-10 -left-10 z-0"></div>

            <div class="relative z-10 space-y-7">
                <div class="text-center md:text-left">
                    <span class="text-[11px] font-bold uppercase tracking-[0.3em] text-gold">Ruang Anggota</span>
                    <h2 class="font-display text-4xl font-semibold text-black tracking-tight mt-1">Selamat Datang Kembali</h2>
                    <p class="text-gray-500 text-sm mt-2">Silakan masuk untuk melanjutkan meracik parfum Anda.</p>
                </div>

                @if (session('status'))
                    <div class="bg-green-50 text-green-700 text-sm p-3 rounded-xl font-semibold border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input-field"
                            placeholder="Masukkan email Anda...">
                        @if ($errors->has('email'))
                            <span class="mt-1 block font-bold text-xs text-red-500">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="input-field"
                               placeholder="Masukkan password Anda...">
                        @if ($errors->has('password'))
                            <span class="mt-1 block font-bold text-xs text-red-500">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between text-sm font-semibold">
                        <label for="remember_me" class="inline-flex items-center text-gray-600 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-[#FF6B86] focus:ring-[#FF6B86]">
                            <span class="ms-2 text-xs">Ingat Saya</span>
                        </label>
                            <a href="https://wa.me/089635773887" class="text-xs text-gray-500 hover:text-[#FF6B86] transition">WhatsApp untuk Lupa Password</a>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 text-white font-semibold text-sm tracking-wide py-4 px-6 rounded-full shadow-md accent-purple hover:bg-[#FF6B86] transition duration-300">
                            Masuk Ke Akun
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </form>

                <div class="text-center pt-1">
                    <p class="text-xs text-gray-500 font-medium">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-[#FF6B86] font-bold hover:underline">Daftar Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-8 text-xs uppercase tracking-widest text-gray-400 border-t border-[#F1E4C8]">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

</body>
</html>