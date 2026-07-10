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
        
        @keyframes wave {
            0% { transform: translateX(0) translateZ(0) scaleY(1); }
            50% { transform: translateX(-25%) translateZ(0) scaleY(0.8); }
            100% { transform: translateX(-50%) translateZ(0) scaleY(1); }
        }
        .water-wave { animation: wave 3s linear infinite; }
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

        @if ($errors->any())
            <div class="mb-5 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl font-semibold shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            <div class="lg:col-span-2 bg-white p-8 rounded-2xl border-4 border-pink shadow-xl space-y-6">
                <form action="{{ route('parfum.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Komposisi Aroma Utama & Takaran (ml)</label>
                        <div class="space-y-3">
                            @php
                                $colors = ['#FF6BD0', '#FF6B86', '#8B5CF6', '#3B82F6', '#10B981', '#F59E0B'];
                            @endphp

                            @forelse($formulaAroma as $index => $aroma)
                                <div class="border-2 border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition bg-[#FCF3EE]/30 hover:border-[#FF6BD0]">
                                    <div class="flex items-center space-x-3 flex-1">
                                        <input type="checkbox" name="aroma_id[]" value="{{ $aroma->formula_id }}" 
                                            data-color="{{ $colors[$index % count($colors)] }}"
                                            class="aroma-checkbox rounded text-[#FF6B86] focus:ring-[#FF6B86] w-5 h-5">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900 text-sm">{{ $aroma->nama_aroma }}</span>
                                            <span class="text-xs text-gray-400 mt-0.5">{{ $aroma->deskripsi ?? 'Aroma esens murni' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Takaran:</label>
                                        <input type="number" name="takaran[{{ $aroma->formula_id }}]" value="0" min="0" max="100" 
                                               class="takaran-input w-20 p-2 text-center rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-xs font-bold transition">
                                        <span class="text-xs font-bold text-gray-400">ml</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 bg-gray-50 border border-dashed rounded-xl">
                                    <p class="text-xs font-semibold text-gray-400">Belum ada data formula aroma di database.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ukuran Botol Parfum</label>
                        <select id="size-select" name="ukuran_botol" class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold transition">
                            <option value="30ml">Mini Size - 30 ml</option>
                            <option value="50ml" selected>Medium Size - 50 ml</option>
                            <option value="100ml">Signature Size - 100 ml</option>
                            <option value="200ml">King Size - 200 ml</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full text-white font-bold text-base py-3.5 px-6 rounded-xl shadow-md accent-purple hover:bg-[#FF6B86] transition duration-200">
                            Simpan & Racik Parfum Sekarang &rarr;
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex justify-center lg:sticky lg:top-6">
                <div class="w-72 h-96 bg-white rounded-2xl border-4 border-pink shadow-xl flex flex-col items-center justify-end p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#FCF3EE] rounded-full -mr-8 -mt-8 z-20"></div>
                    
                    <div class="w-16 h-6 bg-gray-300 rounded-t-md mb-0.5 border border-gray-400 shadow-sm relative z-10 transition-all duration-500"></div>
                    
                    <div id="bottle-glass" class="w-40 h-48 bg-[#FCF3EE]/40 rounded-b-xl border-2 border-purple flex flex-col items-center justify-center shadow-inner relative overflow-hidden bg-white transition-all duration-500 ease-in-out">
                        
                        <div id="liquid-layer" class="absolute bottom-0 left-0 right-0 h-0 transition-all duration-500 ease-out" style="background-color: transparent;">
                            <div class="water-wave absolute -top-2 left-0 right-0 h-3 bg-black/10 opacity-40 w-[200%] rounded-full blur-[1px]"></div>
                        </div>

                        <div class="relative z-10 flex flex-col items-center justify-center bg-white/80 px-3 py-1.5 rounded-md shadow-sm border border-pink/30">
                            <span class="text-[9px] font-mono tracking-widest text-gray-400">E-BLEND</span>
                            <span id="bottle-size-label" class="text-[10px] font-bold tracking-wider text-black">50 ML</span>
                            <div class="w-6 h-0.5 bg-[#FF6B86] mt-1"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <footer class="text-center py-8 text-sm text-gray-500 border-t border-gray-200">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.aroma-checkbox');
            const takaranInputs = document.querySelectorAll('.takaran-input');
            const liquidLayer = document.getElementById('liquid-layer');
            const sizeSelect = document.getElementById('size-select');
            const bottleGlass = document.getElementById('bottle-glass');
            const bottleSizeLabel = document.getElementById('bottle-size-label');

            function updateBottleSize() {
                const selectedSize = sizeSelect.value;
                bottleGlass.classList.remove('h-36', 'h-44', 'h-52', 'h-60');
                
                if (selectedSize === '30ml') {
                    bottleGlass.classList.add('h-36');
                    bottleSizeLabel.textContent = '30 ML';
                } else if (selectedSize === '50ml') {
                    bottleGlass.classList.add('h-44');
                    bottleSizeLabel.textContent = '50 ML';
                } else if (selectedSize === '100ml') {
                    bottleGlass.classList.add('h-52');
                    bottleSizeLabel.textContent = '100 ML';
                } else if (selectedSize === '200ml') {
                    bottleGlass.classList.add('h-60');
                    bottleSizeLabel.textContent = '200 ML';
                }
                updateLiquid();
            }

            function updateLiquid() {
                const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
                const totalChecked = checkedBoxes.length;

                if (totalChecked === 0) {
                    liquidLayer.style.height = '0%';
                    liquidLayer.style.backgroundColor = 'transparent';
                } else {
                    const fillPercentage = Math.min(totalChecked * 25, 100);
                    liquidLayer.style.height = `${fillPercentage}%`;

                    const latestColor = checkedBoxes[totalChecked - 1].getAttribute('data-color');
                    liquidLayer.style.backgroundColor = latestColor;
                }
            }

            checkboxes.forEach((cb, i) => {
                cb.addEventListener('change', function() {
                    if(!this.checked) takaranInputs[i].value = 0;
                    if(this.checked && takaranInputs[i].value == 0) takaranInputs[i].value = 5; 
                    updateLiquid();
                });
            });

            takaranInputs.forEach((input, i) => {
                input.addEventListener('input', function() {
                    if(parseInt(this.value) > 0) {
                        checkboxes[i].checked = true;
                    } else {
                        checkboxes[i].checked = false;
                    }
                    updateLiquid();
                });
            });

            sizeSelect.addEventListener('change', updateBottleSize);
            updateBottleSize();
        });
    </script>

</body>
</html>