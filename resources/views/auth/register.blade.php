<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru | E-Blend Parfume</title>
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
            <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-[#FF6B86] transition">Masuk</a>
        </nav>
    </header>

    <main class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-lg bg-white p-8 md:p-10 rounded-2xl border-4 border-pink shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#FCF3EE] rounded-full -mr-8 -mt-8"></div>
            
            <div class="relative z-10 space-y-6">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-extrabold text-black tracking-tight">Buat Akun Anda</h2>
                    <p class="text-gray-500 text-sm mt-1">Daftarkan diri Anda untuk mulai mengonsep aroma kustom impian.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nama" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" :value="old('nama')" required autofocus autocomplete="name"
                               class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition"
                               placeholder="Masukkan nama lengkap Anda...">
                        @if ($errors->has('nama'))
                            <span class="mt-1 block font-bold text-xs text-red-500">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nomor Telepon / WA</label>
                        <input id="no_hp" type="text" name="no_hp" :value="old('no_hp')" required autocomplete="tel"
                               class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition"
                               placeholder="Contoh: 081234567890...">
                        @if ($errors->has('no_hp'))
                            <span class="mt-1 block font-bold text-xs text-red-500">{{ $errors->first('no_hp') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Alamat Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                               class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition"
                               placeholder="Contoh: nama@email.com...">
                        @if ($errors->has('email'))
                            <span class="mt-1 block font-bold text-xs text-red-500">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="alamat" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Alamat Pengiriman Lengkap</label>
                        <textarea id="alamat" name="alamat" required rows="2"
                                  class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition resize-none"
                                  placeholder="Masukkan alamat rumah lengkap untuk pengiriman parfum..."></textarea>
                        @if ($errors->has('alamat'))
                            <span class="mt-1 block font-bold text-xs text-red-500">{{ $errors->first('alamat') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition"
                               placeholder="Minimal 8 karakter, gunakan kombinasi huruf, angka, dan simbol...">
                        @if ($errors->has('password'))
                            <span class="mt-1 block font-bold text-xs text-red-500">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full mt-1.5 p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition"
                               placeholder="Ulangi password Anda...">
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full text-white font-bold text-base py-3.5 px-6 rounded-xl shadow-md accent-purple hover:bg-[#FF6B86] transition duration-200">
                            Daftar Sekarang &rarr;
                        </button>
                    </div>
                </form>

                <div class="text-center pt-1">
                    <p class="text-xs text-gray-500 font-medium">
                        Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#FF6B86] font-bold hover:underline">Masuk di sini</a>
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