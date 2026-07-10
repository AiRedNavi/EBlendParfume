<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorium Custom Parfum | E-Blend Parfume</title>
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
            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold hover:text-[#FF6B86] transition">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-500 hover:text-red-600 transition">Keluar</button>
            </form>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-12 flex-1 w-full space-y-10">
        
        <div class="border-b border-gray-200 pb-3">
            <h2 class="text-2xl font-extrabold text-black tracking-tight">Ruang Racik Parfum Kustom</h2>
            <p class="text-gray-500 text-sm mt-1">Tentukan kombinasi formula aroma terbaik Anda sendiri.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            <div class="lg:col-span-2 bg-white p-8 rounded-2xl border-4 border-pink shadow-xl space-y-6">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Komposisi Aroma Utama</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($formulaAramas as $aroma)
                                <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer hover:border-[#FF6BD0] transition bg-[#FCF3EE]/30">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 text-sm">{{ $aroma->nama_aroma }}</span>
                                        <span class="text-xs text-gray-400 mt-0.5">{{ $aroma->deskripsi ?? 'Aroma esens murni' }}</span>
                                    </div>
                                    <input type="checkbox" name="aroma[]" value="{{ $aroma->id }}" class="rounded text-[#FF6B86] focus:ring-[#FF6B86] w-4 h-4">
                                </label>
                            @empty
                                <div class="col-span-2 text-center py-4 bg-gray-50 border border-dashed rounded-xl">
                                    <p class="text-xs font-semibold text-gray-400">Belum ada data formula aroma di database.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ukuran Botol Parfum</label>
                        <select name="ukuran_botol" class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition">
                            <option value="30">Mini Size - 30 ml</option>
                            <option value="50">Medium Size - 50 ml</option>
                            <option value="100">Signature Size - 100 ml</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full text-white font-bold text-base py-3.5 px-6 rounded-xl shadow-md accent-purple hover:bg-[#FF6B86] transition duration-200">
                            Simpan & Pesan Racikan Ini &rarr;
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex justify-center lg:sticky lg:top-6">
                <div class="w-72 h-96 bg-white rounded-2xl border-4 border-pink shadow-xl flex flex-col items-center justify-center p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#FCF3EE] rounded-full -mr-8 -mt-8"></div>
                    <div class="w-24 h-8 bg-gray-200 rounded-t-md mb-1 border border-gray-400"></div>
                    <div class="w-40 h-52 bg-[#FCF3EE] rounded-b-xl border-2 border-purple flex flex-col items-center justify-center shadow-inner">
                        <span class="text-xs font-mono tracking-widest text-gray-400 mb-2">E-BLEND</span>
                        <span class="text-sm font-bold tracking-wider text-black">YOUR LAB</span>
                        <div class="w-12 h-0.5 bg-[#FF6B86] mt-2"></div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <footer class="text-center py-8 text-sm text-gray-500 border-t border-gray-200">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

</body>
</html>