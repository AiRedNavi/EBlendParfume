<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun | E-Blend Parfume</title>
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
        <nav class="space-x-6">
            <a href="{{ route('register') }}" class="text-sm font-semibold hover:text-[#FF6B86] transition">Daftar Akun</a>
        </nav>
    </header>

    <main class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-2xl border-4 border-pink shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#FCF3EE] rounded-full -mr-8 -mt-8"></div>
            
            <div class="relative z-10 space-y-6">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-extrabold text-black tracking-tight">Selamat Datang Kembali</h2>
                    <p class="text-gray-500 text-sm mt-1">Silakan masuk untuk melanjutkan meracik parfum Anda.</p>
                </div>

                @if (session('status'))
                    <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg font-semibold border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition"
                            placeholder="Masukkan email Anda...">
                        @if ($errors->has('email'))
                            <span class="mt-1 block font-bold text-xs text-red-500">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition"
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
                            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="text-xs text-gray-500 hover:text-[#FF6B86] transition">Lupa Password?</a>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full text-white font-bold text-base py-3.5 px-6 rounded-xl shadow-md accent-purple hover:bg-[#FF6B86] transition duration-200">
                            Masuk Ke Akun &rarr;
                        </button>
                    </div>
                </form>

                <div class="text-center pt-2">
                    <p class="text-xs text-gray-500 font-medium">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-[#FF6B86] font-bold hover:underline">Daftar Sekarang</a>
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