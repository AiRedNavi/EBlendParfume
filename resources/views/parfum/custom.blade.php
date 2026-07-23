<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorium Custom Parfum | E-Blend Parfume</title>
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

        .aroma-row { transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease; }
        .aroma-row:hover { transform: translateY(-2px); box-shadow: 0 16px 34px -20px rgba(180,146,76,0.4); border-color: var(--gold-light); }
        .aroma-row.is-active { border-color: var(--gold); background-color: #fffdf8; box-shadow: 0 16px 34px -20px rgba(180,146,76,0.35); }

        input[type="checkbox"].aroma-checkbox { accent-color: var(--pink); }

        .bottle-cap {
            background: linear-gradient(180deg, var(--gold-light) 0%, var(--gold) 60%, #96793a 100%);
        }

        /* ===== Bottle & Liquid Fancy Animation ===== */
        #bottle-frame {
            transition: box-shadow .6s ease, border-color .6s ease;
        }
        #bottle-frame.is-filling {
            box-shadow: 0 30px 70px -25px rgba(180,146,76,0.55);
        }

        #bottle-glass {
            background: linear-gradient(160deg, #ffffff 0%, var(--cream) 55%, #ffffff 100%);
            transition: height 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        #liquid-layer {
            transition: height 0.9s cubic-bezier(0.22, 1, 0.36, 1), background 0.6s ease;
            filter: saturate(1.15);
        }

        .glass-shine {
            position: absolute;
            top: 6%;
            left: 14%;
            width: 14%;
            height: 82%;
            background: linear-gradient(180deg, rgba(255,255,255,0.75), rgba(255,255,255,0.05));
            border-radius: 999px;
            filter: blur(1px);
            pointer-events: none;
            z-index: 20;
        }

        @keyframes waveMove {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .wave-layer {
            position: absolute;
            left: 0;
            width: 200%;
            height: 14px;
            background-repeat: repeat-x;
        }
        .wave-back {
            top: -7px;
            opacity: 0.35;
            animation: waveMove 4.5s linear infinite;
            background-image: radial-gradient(ellipse at center, rgba(255,255,255,0.55) 0%, transparent 70%);
            background-size: 60px 20px;
        }
        .wave-front {
            top: -5px;
            opacity: 0.55;
            animation: waveMove 3s linear infinite reverse;
            background-image: radial-gradient(ellipse at center, rgba(255,255,255,0.7) 0%, transparent 70%);
            background-size: 40px 16px;
        }

        @keyframes bubbleRise {
            0% { transform: translateY(0) scale(0.6); opacity: 0; }
            15% { opacity: 0.8; }
            100% { transform: translateY(-90px) scale(1); opacity: 0; }
        }
        .bubble {
            position: absolute;
            bottom: 4px;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255,255,255,0.8);
            animation: bubbleRise 2.6s ease-in infinite;
            pointer-events: none;
            z-index: 15;
        }

        @keyframes sparkle {
            0%, 100% { opacity: 0; transform: scale(0.5); }
            50% { opacity: 1; transform: scale(1.1); }
        }
        .sparkle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: radial-gradient(circle, #fff 0%, transparent 70%);
            border-radius: 50%;
            animation: sparkle 2.2s ease-in-out infinite;
            pointer-events: none;
            z-index: 21;
        }

        @media (prefers-reduced-motion: reduce) {
            .fade-up, .aroma-row, .wave-back, .wave-front, .bubble, .sparkle { animation: none !important; transition: none !important; }
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
            <a href="{{ url('/dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-[#FF6B86] transition">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition">Keluar</button>
            </form>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-14 flex-1 w-full space-y-10">

        <div class="fade-up fade-up-1 flex items-center gap-4">
            <span class="hairline flex-1"></span>
            <span class="text-[11px] font-bold uppercase tracking-[0.35em] text-gold whitespace-nowrap">Laboratorium Parfum</span>
            <span class="hairline flex-1"></span>
        </div>

        <div class="fade-up fade-up-1 text-center md:text-left">
            <h2 class="font-display text-4xl font-semibold text-black tracking-tight">Ruang Racik Parfum Kustom</h2>
            <p class="text-gray-500 text-sm mt-2">Tentukan kombinasi formula aroma terbaik Anda sendiri.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-r-xl font-semibold shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

            <div class="fade-up fade-up-2 lg:col-span-2 bg-white p-8 md:p-10 rounded-[28px] border border-[#F1E4C8] shadow-[0_30px_60px_-30px_rgba(180,146,76,0.25)] space-y-7">
                <form action="{{ route('parfum.store') }}" method="POST" class="space-y-7">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-bold text-gold uppercase tracking-[0.25em] mb-3">Pilih Komposisi Aroma Utama & Takaran (ml)</label>
                        <div class="space-y-3">
                            @php
                                $colors = ['#FF6BD0', '#FF6B86', '#8B5CF6', '#3B82F6', '#10B981', '#F59E0B'];
                            @endphp

                            @forelse($formulaAroma as $index => $aroma)
                                <div class="aroma-row border border-[#F1E4C8] rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#FCF3EE]/30">
                                    <div class="flex items-center space-x-3 flex-1">
                                        <input type="checkbox" name="aroma_id[]" value="{{ $aroma->formula_id }}"
                                            data-color="{{ $colors[$index % count($colors)] }}"
                                            data-price="{{ $aroma->harga_per_ml }}"
                                            class="aroma-checkbox rounded text-[#FF6B86] focus:ring-[#FF6B86] w-5 h-5">
                                        <div class="flex flex-col">
                                            <span class="font-data text-sm text-gray-900">{{ $aroma->nama_formula }}</span>
                                            <span class="text-xs text-gray-400 mt-0.5">{{ $aroma->deskripsi ?? 'Aroma esens murni' }}</span>
                                            <span class="font-data text-xs font-semibold text-gold mt-0.5">Rp {{ number_format($aroma->harga_per_ml, 0, ',', '.') }} / ml</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end space-y-1 w-full sm:w-auto">
                                        <div class="flex items-center space-x-2">
                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">Takaran:</label>
                                            <input type="number" name="takaran[{{ $aroma->formula_id }}]" value="0" min="0" max="100"
                                                   data-price="{{ $aroma->harga_per_ml }}"
                                                   class="takaran-input w-20 p-2 text-center rounded-lg border border-[#F1E4C8] focus:border-gold outline-none text-xs font-bold transition">
                                            <span class="text-xs font-bold text-gray-400">ml</span>
                                        </div>
                                        <span class="subtotal-label font-data text-xs text-gray-500">Subtotal: Rp 0</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 bg-white border border-dashed border-[#F1E4C8] rounded-xl">
                                    <p class="text-xs font-semibold text-gray-400">Belum ada data formula aroma di database.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gold uppercase tracking-[0.25em] mb-3">Ukuran Botol Parfum</label>
                        <select id="size-select" name="ukuran_botol" class="w-full p-3 rounded-xl border border-[#F1E4C8] focus:border-gold outline-none text-sm font-semibold transition bg-white">
                            <option value="30ml">Mini Size - 30 ml</option>
                            <option value="50ml" selected>Medium Size - 50 ml</option>
                            <option value="100ml">Signature Size - 100 ml</option>
                            <option value="200ml">King Size - 200 ml</option>
                        </select>
                    </div>

                    {{-- Ringkasan Total Harga (live update) --}}
                    <div class="bg-[#FCF3EE] border border-gold-light rounded-2xl p-5 space-y-1.5" style="border-color: var(--gold-light);">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal Aroma:</span>
                            <span id="subtotal-aroma" class="font-data">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Biaya Botol Kaca Eksklusif:</span>
                            <span class="font-data">Rp 15.000</span>
                        </div>
                        <div class="hairline-full my-1"></div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="font-display text-lg font-semibold text-black">Estimasi Total</span>
                            <span id="total-harga" class="font-data text-xl font-semibold text-purple">Rp 15.000</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 text-white font-semibold text-sm tracking-wide py-4 px-6 rounded-full shadow-md accent-purple hover:bg-[#FF6B86] transition duration-300">
                            Simpan & Racik Parfum Sekarang
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="fade-up fade-up-2 flex justify-center lg:sticky lg:top-24">
                <div id="bottle-frame" class="w-72 h-96 bg-white rounded-[28px] border border-[#F1E4C8] shadow-[0_30px_60px_-30px_rgba(180,146,76,0.25)] flex flex-col items-center justify-end p-8 relative overflow-hidden">
                    <div class="absolute w-56 h-56 rounded-full bg-gold-soft/60 blur-3xl -top-10 -right-10 z-0"></div>
                    <div class="absolute w-40 h-40 rounded-full bg-[#FF6BD0]/10 blur-3xl -bottom-8 -left-8 z-0"></div>

                    <div class="w-16 h-6 bottle-cap rounded-t-md mb-0.5 shadow-md relative z-10 transition-all duration-500"></div>

                    <div id="bottle-glass" class="w-40 h-48 rounded-b-xl border-2 border-purple flex flex-col items-center justify-center shadow-inner relative overflow-hidden transition-all duration-500 ease-in-out z-10">

                        <div class="glass-shine"></div>

                        <div id="liquid-layer" class="absolute bottom-0 left-0 right-0 h-0" style="background-color: transparent;">
                            <div class="wave-layer wave-back"></div>
                            <div class="wave-layer wave-front"></div>
                            <div id="bubble-container" class="absolute inset-0"></div>
                        </div>

                        <div class="relative z-10 flex flex-col items-center justify-center bg-white/80 px-3 py-1.5 rounded-md shadow-sm border border-pink/30">
                            <span class="text-[9px] font-bold tracking-[0.3em] text-gold uppercase">E-Blend</span>
                            <span id="bottle-size-label" class="font-display text-sm font-semibold text-black">50 ML</span>
                            <div class="w-6 h-0.5 bg-[#FF6B86] mt-1"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <footer class="text-center py-8 text-xs uppercase tracking-widest text-gray-400 border-t border-[#F1E4C8]">
        &copy; {{ date('Y') }} E-Blend Parfume Project. All rights reserved.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.aroma-checkbox');
            const takaranInputs = document.querySelectorAll('.takaran-input');
            const subtotalLabels = document.querySelectorAll('.subtotal-label');
            const liquidLayer = document.getElementById('liquid-layer');
            const sizeSelect = document.getElementById('size-select');
            const bottleGlass = document.getElementById('bottle-glass');
            const bottleFrame = document.getElementById('bottle-frame');
            const bottleSizeLabel = document.getElementById('bottle-size-label');
            const subtotalAromaEl = document.getElementById('subtotal-aroma');
            const totalHargaEl = document.getElementById('total-harga');
            const bubbleContainer = document.getElementById('bubble-container');

            const BIAYA_BOTOL = 15000;
            let bubbleTimer = null;

            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

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

            // Blend semua warna aroma yang aktif menjadi gradasi cair yang mewah,
            // alih-alih hanya menampilkan satu warna terakhir.
            function updateLiquid() {
                const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
                const totalChecked = checkedBoxes.length;

                if (totalChecked === 0) {
                    liquidLayer.style.height = '0%';
                    liquidLayer.style.background = 'transparent';
                    bottleFrame.classList.remove('is-filling');
                    clearBubbles();
                    return;
                }

                const fillPercentage = Math.min(totalChecked * 25, 100);
                liquidLayer.style.height = fillPercentage + '%';

                const colorList = checkedBoxes.map(cb => cb.getAttribute('data-color'));
                if (colorList.length === 1) {
                    liquidLayer.style.background = `linear-gradient(180deg, ${colorList[0]}dd, ${colorList[0]})`;
                } else {
                    const stops = colorList.map((c, i) => `${c} ${(i / (colorList.length - 1) * 100).toFixed(0)}%`).join(', ');
                    liquidLayer.style.background = `linear-gradient(120deg, ${stops})`;
                }

                bottleFrame.classList.add('is-filling');
                spawnBubbles();
            }

            function clearBubbles() {
                bubbleContainer.innerHTML = '';
                if (bubbleTimer) clearInterval(bubbleTimer);
            }

            function spawnBubbles() {
                clearBubbles();
                bubbleTimer = setInterval(() => {
                    if (parseFloat(liquidLayer.style.height) <= 0) return;
                    const bubble = document.createElement('span');
                    bubble.className = 'bubble';
                    bubble.style.left = (10 + Math.random() * 80) + '%';
                    bubble.style.animationDuration = (2 + Math.random() * 1.5) + 's';
                    bubble.style.width = bubble.style.height = (3 + Math.random() * 3) + 'px';
                    bubbleContainer.appendChild(bubble);
                    setTimeout(() => bubble.remove(), 2800);
                }, 450);
            }

            function updateTotalHarga() {
                let subtotalAroma = 0;

                takaranInputs.forEach((input, i) => {
                    const takaran = parseFloat(input.value) || 0;
                    const harga = parseFloat(input.getAttribute('data-price')) || 0;
                    const isChecked = checkboxes[i].checked;
                    const subtotalItem = isChecked ? takaran * harga : 0;

                    subtotalLabels[i].textContent = 'Subtotal: ' + formatRupiah(subtotalItem);
                    subtotalAroma += subtotalItem;

                    const row = checkboxes[i].closest('.aroma-row');
                    if (row) row.classList.toggle('is-active', isChecked);
                });

                const total = subtotalAroma + BIAYA_BOTOL;
                subtotalAromaEl.textContent = formatRupiah(subtotalAroma);
                totalHargaEl.textContent = formatRupiah(total);
            }

            checkboxes.forEach((cb, i) => {
                cb.addEventListener('change', function() {
                    if(!this.checked) takaranInputs[i].value = 0;
                    if(this.checked && takaranInputs[i].value == 0) takaranInputs[i].value = 5;
                    updateLiquid();
                    updateTotalHarga();
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
                    updateTotalHarga();
                });
            });

            sizeSelect.addEventListener('change', updateBottleSize);
            updateBottleSize();
            updateTotalHarga();
        });
    </script>

</body>
</html>