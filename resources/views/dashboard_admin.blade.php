<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | E-Blend Parfume</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,500&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #131118;
            --dark-surface: #1D1A24;
            --dark-surface-2: #26212F;
            --dark-border: #363040;
            --dark-text: #F3EFE8;
            --dark-text-dim: #B3A9C4;
            --dark-text-faint: #837a92;
            --purple: #FF6BD0;
            --pink: #FF6B86;
            --gold: #CBA45C;
            --gold-light: #E1C687;
            --gold-soft: rgba(203,164,92,0.14);
        }
        body { background-color: var(--dark-bg); color: var(--dark-text); font-family: 'Manrope', sans-serif; }
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
        .nav-link { cursor: pointer; }

        .grain-bg {
            background-image: radial-gradient(circle at 12% 0%, rgba(255,107,208,0.06), transparent 40%),
                               radial-gradient(circle at 90% 8%, rgba(203,164,92,0.08), transparent 45%),
                               radial-gradient(circle at 85% 95%, rgba(255,107,134,0.05), transparent 40%);
        }
        .hairline { height: 1px; background: linear-gradient(90deg, transparent, rgba(203,164,92,0.35), transparent); }

        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(6,5,9,0.72);
            backdrop-filter: blur(2px);
            z-index: 50;
            align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .view-toggle-btn.active {
            background-color: var(--gold);
            color: #17141D;
        }
        .view-grid { display: none; }
        .view-grid.active { display: grid; }
        .view-table.hidden-view { display: none; }

        /* status indicator dot — replaces colored emoji circles */
        .status-dot {
            display: inline-block;
            width: 7px; height: 7px;
            border-radius: 999px;
            margin-right: 6px;
            vertical-align: middle;
            box-shadow: 0 0 0 3px currentColor / 15%;
        }
        .icon { display: inline-block; vertical-align: -3px; }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col justify-between grain-bg">

    <header class="bg-[#191620]/90 backdrop-blur-sm shadow-lg py-5 px-8 flex flex-col sm:flex-row justify-between items-center border-b border-[color:var(--dark-border)] gap-4 sticky top-0 z-30">
        <a href="/" class="font-display text-2xl font-semibold tracking-wide text-[color:var(--dark-text)]">E<span class="text-purple">-Blend Admin</span></a>

        <nav class="flex items-center gap-5 flex-wrap justify-center">
            <a href="#section-pesanan" class="nav-link text-xs font-bold uppercase tracking-widest text-[color:var(--dark-text-dim)] hover:text-[#FF6B86] transition inline-flex items-center gap-1.5">
                <svg class="icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8l-9-5-9 5 9 5 9-5zM3 8v8l9 5 9-5V8M12 13v8"/></svg>
                Pesanan
            </a>
            <a href="#section-customer" class="nav-link text-xs font-bold uppercase tracking-widest text-[color:var(--dark-text-dim)] hover:text-[#FF6B86] transition inline-flex items-center gap-1.5">
                <svg class="icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1M10 11a4 4 0 100-8 4 4 0 000 8zM23 20v-1a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Customer
            </a>
            <a href="#section-formula" class="nav-link text-xs font-bold uppercase tracking-widest text-[color:var(--dark-text-dim)] hover:text-[#FF6B86] transition inline-flex items-center gap-1.5">
                <svg class="icon w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6M10 3v6.5L4.5 19a1.5 1.5 0 001.3 2.2h12.4a1.5 1.5 0 001.3-2.2L14 9.5V3"/></svg>
                Formula Aroma
            </a>
        </nav>

        <div class="flex items-center gap-4">
            <span class="text-xs font-semibold text-[color:var(--dark-text-dim)]">Halo, <span class="text-[color:var(--dark-text)] font-data">{{ Auth::user()->nama }}</span>
                <span class="ml-1 text-[10px] font-bold uppercase tracking-widest text-[#17141D] bg-gold px-2 py-0.5 rounded-full">Admin</span>
            </span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs font-bold uppercase tracking-widest text-[color:var(--dark-text-faint)] hover:text-red-400 transition">Keluar</button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-14 flex-1 w-full space-y-16">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-xl relative flex items-center gap-2" role="alert">
                <svg class="icon w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-500/10 border-l-4 border-red-500 text-red-300 p-4 rounded-r-xl font-semibold shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ================= SECTION: PESANAN ================= --}}
        <section id="section-pesanan" class="scroll-mt-28 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-[color:var(--dark-border)] pb-4 gap-3">
                <h2 class="font-display text-3xl font-semibold text-[color:var(--dark-text)] tracking-tight inline-flex items-center gap-2">
                    <svg class="icon w-5 h-5 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8l-9-5-9 5 9 5 9-5zM3 8v8l9 5 9-5V8M12 13v8"/></svg>
                    Manajemen Pesanan Pelanggan
                </h2>
                <span class="bg-gold-soft text-gold text-xs font-bold px-3 py-1.5 rounded-full border border-gold/30">Total: {{ $semua_pesanan->count() }} Transaksi</span>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 flex-wrap">
                <div class="relative w-full sm:w-72">
                    <svg class="icon w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-[color:var(--dark-text-faint)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" id="search-pesanan" placeholder="Cari ID pesanan atau nama pelanggan..."
                        class="w-full p-2.5 pl-10 rounded-xl border border-[color:var(--dark-border)] bg-[color:var(--dark-surface)] text-[color:var(--dark-text)] placeholder:text-[color:var(--dark-text-faint)] focus:border-gold outline-none text-sm">
                </div>

                <select id="filter-status-pesanan" class="p-2.5 rounded-xl border border-[color:var(--dark-border)] bg-[color:var(--dark-surface)] focus:border-gold outline-none text-sm font-semibold text-[color:var(--dark-text)]">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Pembayaran">Belum Dibayar</option>
                    <option value="Pembayaran Dikirim">Perlu Cek Bukti</option>
                    <option value="Pesanan Diproses">Sedang Diracik</option>
                    <option value="Pesanan Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>

                <button type="button" id="sort-pesanan-btn" data-order="desc"
                    class="p-2.5 rounded-xl border border-[color:var(--dark-border)] hover:border-gold text-sm font-semibold text-[color:var(--dark-text-dim)] transition inline-flex items-center gap-1.5">
                    <svg id="sort-icon" class="icon w-4 h-4 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12l7 7 7-7"/></svg>
                    <span id="sort-label">Terbaru</span>
                </button>

                <button type="button" id="quick-unpaid-btn"
                    class="p-2.5 rounded-xl border border-amber-500/40 bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 text-sm font-bold transition inline-flex items-center gap-1.5">
                    <span class="status-dot" style="background-color:#f59e0b; box-shadow:none;"></span>
                    Sorot Belum Dibayar
                </button>

                <div class="ml-0 sm:ml-auto flex items-center gap-1 bg-[color:var(--dark-surface)] border border-[color:var(--dark-border)] rounded-xl p-1">
                    <button type="button" class="view-toggle-btn active text-xs font-bold px-3 py-2 rounded-lg transition inline-flex items-center gap-1.5" data-target="pesanan" data-view="table">
                        <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        Tabel
                    </button>
                    <button type="button" class="view-toggle-btn text-xs font-bold px-3 py-2 rounded-lg transition inline-flex items-center gap-1.5 text-[color:var(--dark-text-dim)]" data-target="pesanan" data-view="grid">
                        <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="7" height="7" rx="1"/><rect x="13" y="4" width="7" height="7" rx="1"/><rect x="4" y="13" width="7" height="7" rx="1"/><rect x="13" y="13" width="7" height="7" rx="1"/></svg>
                        Kartu
                    </button>
                </div>
            </div>

            {{-- TAMPILAN TABEL --}}
            <div id="view-table-pesanan" class="view-table bg-[color:var(--dark-surface)] rounded-2xl shadow-xl border border-[color:var(--dark-border)] overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="table-pesanan" class="min-w-full divide-y divide-[color:var(--dark-border)] text-left text-sm">
                        <thead class="bg-[color:var(--dark-surface-2)] text-[11px] uppercase text-[color:var(--dark-text-dim)] font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">ID Pesanan</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Detail Parfum</th>
                                <th class="px-6 py-4">Total Harga</th>
                                <th class="px-6 py-4">Bukti Bayar</th>
                                <th class="px-6 py-4">Status Saat Ini</th>
                                <th class="px-6 py-4 text-center">Aksi Operasional</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--dark-border)] bg-[color:var(--dark-surface)]">
                            @forelse($semua_pesanan as $pesanan)
                                <tr class="item-pesanan hover:bg-[color:var(--dark-surface-2)] transition {{ $pesanan->status_pesanan === 'Menunggu Pembayaran' ? 'bg-amber-500/5 ring-1 ring-inset ring-amber-500/25' : '' }}"
                                    data-status="{{ $pesanan->status_pesanan }}"
                                    data-created="{{ optional($pesanan->created_at)->timestamp ?? 0 }}"
                                    data-search="{{ strtolower($pesanan->pesanan_id . ' ' . ($pesanan->user->nama ?? '')) }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-[color:var(--dark-text-dim)]">
                                        {{ $pesanan->pesanan_id }}
                                        @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                            <span class="ml-1 text-amber-500" title="Belum dibayar">●</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-data text-[color:var(--dark-text)]">{{ $pesanan->user->nama ?? 'User Terhapus' }}</div>
                                        <div class="text-xs text-[color:var(--dark-text-faint)]">ID User: {{ $pesanan->user_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[color:var(--dark-text-dim)]">
                                        Custom Botol ({{ $pesanan->ukuran_botol_ml }})
                                        <span class="block text-xs text-[color:var(--dark-text-faint)]">Alkohol: {{ $pesanan->alkohol_ml }}ml</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-data text-[color:var(--dark-text)]">
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pesanan->pembayaran && $pesanan->pembayaran->bukti_pembayaran)
                                            <button type="button"
                                                onclick="document.getElementById('modal-bukti-{{ $pesanan->pesanan_id }}').classList.add('active')"
                                                class="bg-blue-500/10 hover:bg-blue-500/20 text-blue-300 text-xs font-bold py-2 px-3 rounded-lg border border-blue-500/30 transition inline-flex items-center gap-1.5">
                                                <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>
                                                Lihat Bukti
                                            </button>
                                        @else
                                            <span class="text-xs text-[color:var(--dark-text-faint)] italic">Belum upload</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/30"><span class="status-dot" style="background-color:#f59e0b;box-shadow:none;"></span>Menunggu Bayar</span>
                                        @elseif($pesanan->status_pesanan === 'Pembayaran Dikirim')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-500/10 text-blue-300 border border-blue-500/30"><span class="status-dot" style="background-color:#3b82f6;box-shadow:none;"></span>Perlu Cek Bukti</span>
                                        @elseif($pesanan->status_pesanan === 'Pesanan Diproses')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-purple-500/10 text-purple-300 border border-purple-500/30"><span class="status-dot" style="background-color:#c084fc;box-shadow:none;"></span>Sedang Diracik</span>
                                        @elseif($pesanan->status_pesanan === 'Pesanan Selesai')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/30"><span class="status-dot" style="background-color:#10b981;box-shadow:none;"></span>Selesai</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-500/10 text-gray-300 border border-gray-500/30"><span class="status-dot" style="background-color:#9ca3af;box-shadow:none;"></span>{{ $pesanan->status_pesanan }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex items-center gap-4">
                                            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->pesanan_id) }}" method="POST" class="inline-flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status_pesanan" class="bg-[color:var(--dark-surface-2)] border border-[color:var(--dark-border)] text-[color:var(--dark-text)] text-xs rounded-lg p-2 focus:ring-gold focus:border-gold">
                                                    <option value="Menunggu Pembayaran" {{ $pesanan->status_pesanan == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                                    <option value="Pembayaran Dikirim" {{ $pesanan->status_pesanan == 'Pembayaran Dikirim' ? 'selected' : '' }}>Pembayaran Dikirim</option>
                                                    <option value="Pesanan Diproses" {{ $pesanan->status_pesanan == 'Pesanan Diproses' ? 'selected' : '' }}>Diproses (Racik)</option>
                                                    <option value="Pesanan Selesai" {{ $pesanan->status_pesanan == 'Pesanan Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="Dibatalkan" {{ $pesanan->status_pesanan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                </select>
                                                <button type="submit" class="bg-gold hover:bg-gold-light text-[#17141D] font-bold text-xs py-2 px-3 rounded-lg transition shadow-sm">
                                                    Simpan
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.pesanan.destroy', $pesanan->pesanan_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan {{ $pesanan->pesanan_id }} secara permanen? Tindakan ini tidak bisa dibatalkan!');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 p-2 rounded-lg border border-red-500/30 transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-[color:var(--dark-text-faint)] font-medium">
                                        Belum ada data pesanan masuk dari pelanggan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAMPILAN KARTU GRID (horizontal, persegi) --}}
            <div id="view-grid-pesanan" class="view-grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @forelse($semua_pesanan as $pesanan)
                    <div class="item-pesanan bg-[color:var(--dark-surface)] rounded-2xl border {{ $pesanan->status_pesanan === 'Menunggu Pembayaran' ? 'border-amber-500/50' : 'border-[color:var(--dark-border)]' }} shadow-md p-5 flex flex-col justify-between aspect-square"
                        data-status="{{ $pesanan->status_pesanan }}"
                        data-created="{{ optional($pesanan->created_at)->timestamp ?? 0 }}"
                        data-search="{{ strtolower($pesanan->pesanan_id . ' ' . ($pesanan->user->nama ?? '')) }}">

                        <div class="space-y-2">
                            <div class="flex items-start justify-between">
                                <span class="font-mono font-bold text-xs text-[color:var(--dark-text-dim)] break-all">{{ $pesanan->pesanan_id }}</span>
                                @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                    <span class="status-dot" style="width:9px;height:9px;background-color:#f59e0b;box-shadow:none;" title="Belum dibayar"></span>
                                @endif
                            </div>
                            <div class="font-data text-[color:var(--dark-text)] text-sm truncate">{{ $pesanan->user->nama ?? 'User Terhapus' }}</div>
                            <div class="text-xs text-[color:var(--dark-text-faint)]">Botol {{ $pesanan->ukuran_botol_ml }} • Alkohol {{ $pesanan->alkohol_ml }}ml</div>
                            <div class="font-data text-[color:var(--dark-text)] text-sm">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>

                            @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/30">Menunggu Bayar</span>
                            @elseif($pesanan->status_pesanan === 'Pembayaran Dikirim')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-500/10 text-blue-300 border border-blue-500/30">Perlu Cek Bukti</span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Diproses')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-purple-500/10 text-purple-300 border border-purple-500/30">Diracik</span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Selesai')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/30">Selesai</span>
                            @else
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-500/10 text-gray-300 border border-gray-500/30">{{ $pesanan->status_pesanan }}</span>
                            @endif
                        </div>

                        <div class="space-y-2 pt-3 border-t border-[color:var(--dark-border)] mt-3">
                            @if($pesanan->pembayaran && $pesanan->pembayaran->bukti_pembayaran)
                                <button type="button"
                                    onclick="document.getElementById('modal-bukti-{{ $pesanan->pesanan_id }}').classList.add('active')"
                                    class="w-full bg-blue-500/10 hover:bg-blue-500/20 text-blue-300 text-[11px] font-bold py-1.5 rounded-lg border border-blue-500/30 transition inline-flex items-center justify-center gap-1">
                                    <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21"/></svg>
                                    Lihat Bukti
                                </button>
                            @endif

                            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->pesanan_id) }}" method="POST" class="flex items-center gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="status_pesanan" class="flex-1 bg-[color:var(--dark-surface-2)] border border-[color:var(--dark-border)] text-[color:var(--dark-text)] text-[11px] rounded-lg p-1.5 focus:ring-gold focus:border-gold">
                                    <option value="Menunggu Pembayaran" {{ $pesanan->status_pesanan == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Pembayaran Dikirim" {{ $pesanan->status_pesanan == 'Pembayaran Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="Pesanan Diproses" {{ $pesanan->status_pesanan == 'Pesanan Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Pesanan Selesai" {{ $pesanan->status_pesanan == 'Pesanan Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Dibatalkan" {{ $pesanan->status_pesanan == 'Dibatalkan' ? 'selected' : '' }}>Batal</option>
                                </select>
                                <button type="submit" class="bg-gold hover:bg-gold-light text-[#17141D] font-bold text-[11px] py-1.5 px-2 rounded-lg transition">
                                    ✓
                                </button>
                            </form>

                            <form action="{{ route('admin.pesanan.destroy', $pesanan->pesanan_id) }}" method="POST" onsubmit="return confirm('Hapus pesanan {{ $pesanan->pesanan_id }} secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 text-[11px] font-bold py-1.5 rounded-lg border border-red-500/30 transition inline-flex items-center justify-center gap-1">
                                    <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-[color:var(--dark-text-faint)] font-medium bg-[color:var(--dark-surface)] rounded-2xl border border-[color:var(--dark-border)]">
                        Belum ada data pesanan masuk dari pelanggan.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ================= SECTION: CUSTOMER ================= --}}
        <section id="section-customer" class="scroll-mt-28 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-[color:var(--dark-border)] pb-4 gap-3">
                <h2 class="font-display text-3xl font-semibold text-[color:var(--dark-text)] tracking-tight inline-flex items-center gap-2">
                    <svg class="icon w-5 h-5 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1M10 11a4 4 0 100-8 4 4 0 000 8zM23 20v-1a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    Daftar Akun Customer
                </h2>
                <span class="bg-gold-soft text-gold text-xs font-bold px-3 py-1.5 rounded-full border border-gold/30">Total: {{ $semua_customer->count() }} Customer</span>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 flex-wrap">
                <div class="relative w-full sm:w-72">
                    <svg class="icon w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-[color:var(--dark-text-faint)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" id="search-customer" placeholder="Cari nama, email, atau no. HP..."
                        class="w-full p-2.5 pl-10 rounded-xl border border-[color:var(--dark-border)] bg-[color:var(--dark-surface)] text-[color:var(--dark-text)] placeholder:text-[color:var(--dark-text-faint)] focus:border-gold outline-none text-sm">
                </div>

                <div class="ml-0 sm:ml-auto flex items-center gap-1 bg-[color:var(--dark-surface)] border border-[color:var(--dark-border)] rounded-xl p-1">
                    <button type="button" class="view-toggle-btn active text-xs font-bold px-3 py-2 rounded-lg transition inline-flex items-center gap-1.5" data-target="customer" data-view="table">
                        <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        Tabel
                    </button>
                    <button type="button" class="view-toggle-btn text-xs font-bold px-3 py-2 rounded-lg transition inline-flex items-center gap-1.5 text-[color:var(--dark-text-dim)]" data-target="customer" data-view="grid">
                        <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="7" height="7" rx="1"/><rect x="13" y="4" width="7" height="7" rx="1"/><rect x="4" y="13" width="7" height="7" rx="1"/><rect x="13" y="13" width="7" height="7" rx="1"/></svg>
                        Kartu
                    </button>
                </div>
            </div>

            {{-- TAMPILAN TABEL --}}
            <div id="view-table-customer" class="view-table bg-[color:var(--dark-surface)] rounded-2xl shadow-xl border border-[color:var(--dark-border)] overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="table-customer" class="min-w-full divide-y divide-[color:var(--dark-border)] text-left text-sm">
                        <thead class="bg-[color:var(--dark-surface-2)] text-[11px] uppercase text-[color:var(--dark-text-dim)] font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">No. HP</th>
                                <th class="px-6 py-4">Alamat</th>
                                <th class="px-6 py-4 text-center">Jumlah Pesanan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--dark-border)] bg-[color:var(--dark-surface)]">
                            @forelse($semua_customer as $customer)
                                <tr class="item-customer hover:bg-[color:var(--dark-surface-2)] transition"
                                    data-search="{{ strtolower($customer->nama . ' ' . $customer->email . ' ' . $customer->no_hp) }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-data text-[color:var(--dark-text)]">{{ $customer->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[color:var(--dark-text-dim)]">{{ $customer->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[color:var(--dark-text-dim)]">{{ $customer->no_hp ?? '-' }}</td>
                                    <td class="px-6 py-4 text-[color:var(--dark-text-dim)] max-w-xs truncate">{{ $customer->alamat ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text-dim)] text-xs font-bold px-2.5 py-1 rounded-full border border-[color:var(--dark-border)]">{{ $customer->pesanan_custom_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-[color:var(--dark-text-faint)] font-medium">
                                        Belum ada akun customer terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAMPILAN KARTU GRID (horizontal, persegi) --}}
            <div id="view-grid-customer" class="view-grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @forelse($semua_customer as $customer)
                    <div class="item-customer bg-[color:var(--dark-surface)] rounded-2xl border border-[color:var(--dark-border)] shadow-md p-5 flex flex-col justify-between aspect-square"
                        data-search="{{ strtolower($customer->nama . ' ' . $customer->email . ' ' . $customer->no_hp) }}">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-full accent-purple flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($customer->nama, 0, 1)) }}
                            </div>
                            <div class="font-data text-[color:var(--dark-text)] text-sm truncate">{{ $customer->nama }}</div>
                            <div class="text-xs text-[color:var(--dark-text-faint)] truncate">{{ $customer->email }}</div>
                            <div class="text-xs text-[color:var(--dark-text-faint)]">{{ $customer->no_hp ?? '-' }}</div>
                            <div class="text-xs text-[color:var(--dark-text-faint)] truncate">{{ $customer->alamat ?? '-' }}</div>
                        </div>
                        <div class="pt-3 border-t border-[color:var(--dark-border)] mt-3">
                            <span class="bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text-dim)] text-[11px] font-bold px-2.5 py-1 rounded-full border border-[color:var(--dark-border)]">{{ $customer->pesanan_custom_count }} Pesanan</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-[color:var(--dark-text-faint)] font-medium bg-[color:var(--dark-surface)] rounded-2xl border border-[color:var(--dark-border)]">
                        Belum ada akun customer terdaftar.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ================= SECTION: FORMULA AROMA ================= --}}
        <section id="section-formula" class="scroll-mt-28 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-[color:var(--dark-border)] pb-4 gap-3">
                <h2 class="font-display text-3xl font-semibold text-[color:var(--dark-text)] tracking-tight inline-flex items-center gap-2">
                    <svg class="icon w-5 h-5 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6M10 3v6.5L4.5 19a1.5 1.5 0 001.3 2.2h12.4a1.5 1.5 0 001.3-2.2L14 9.5V3"/></svg>
                    Manajemen Formula Aroma
                </h2>
                <span class="bg-gold-soft text-gold text-xs font-bold px-3 py-1.5 rounded-full border border-gold/30">Total: {{ $semua_formula->count() }} Formula</span>
            </div>

            {{-- Form Tambah Formula --}}
            <div class="bg-[color:var(--dark-surface)] p-6 rounded-2xl border border-gold/30 shadow-md">
                <h3 class="font-display text-lg font-semibold text-[color:var(--dark-text)] mb-4">Tambah Formula Aroma Baru</h3>
                <form action="{{ route('admin.formula.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <div class="md:col-span-1">
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Nama Formula</label>
                        <input type="text" name="nama_formula" required placeholder="Honey, Cinnamon, Eucalyptus, etc..." class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] placeholder:text-[color:var(--dark-text-faint)] focus:border-gold outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Kategori</label>
                        <input type="text" name="kategori" placeholder="Woody, Citrus, Floral, Nature, Sweet, etc..." class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] placeholder:text-[color:var(--dark-text-faint)] focus:border-gold outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Harga per ml (Rp)</label>
                        <input type="number" step="0.01" min="0" name="harga_per_ml" required placeholder="Rp3.000 - Rp12.000" class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] placeholder:text-[color:var(--dark-text-faint)] focus:border-gold outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" placeholder="Masukkan deskripsi formula..." class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] placeholder:text-[color:var(--dark-text-faint)] focus:border-gold outline-none text-sm">
                    </div>
                    <div class="md:col-span-4">
                        <button type="submit" class="accent-purple hover:bg-[#FF6B86] text-white font-bold text-sm py-2.5 px-6 rounded-xl transition">
                            + Tambah Formula
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 flex-wrap">
                <div class="relative w-full sm:w-72">
                    <svg class="icon w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-[color:var(--dark-text-faint)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" id="search-formula" placeholder="Cari nama formula atau kategori..."
                        class="w-full p-2.5 pl-10 rounded-xl border border-[color:var(--dark-border)] bg-[color:var(--dark-surface)] text-[color:var(--dark-text)] placeholder:text-[color:var(--dark-text-faint)] focus:border-gold outline-none text-sm">
                </div>

                <div class="ml-0 sm:ml-auto flex items-center gap-1 bg-[color:var(--dark-surface)] border border-[color:var(--dark-border)] rounded-xl p-1">
                    <button type="button" class="view-toggle-btn active text-xs font-bold px-3 py-2 rounded-lg transition inline-flex items-center gap-1.5" data-target="formula" data-view="table">
                        <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        Tabel
                    </button>
                    <button type="button" class="view-toggle-btn text-xs font-bold px-3 py-2 rounded-lg transition inline-flex items-center gap-1.5 text-[color:var(--dark-text-dim)]" data-target="formula" data-view="grid">
                        <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="7" height="7" rx="1"/><rect x="13" y="4" width="7" height="7" rx="1"/><rect x="4" y="13" width="7" height="7" rx="1"/><rect x="13" y="13" width="7" height="7" rx="1"/></svg>
                        Kartu
                    </button>
                </div>
            </div>

            {{-- TAMPILAN TABEL --}}
            <div id="view-table-formula" class="view-table bg-[color:var(--dark-surface)] rounded-2xl shadow-xl border border-[color:var(--dark-border)] overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="table-formula" class="min-w-full divide-y divide-[color:var(--dark-border)] text-left text-sm">
                        <thead class="bg-[color:var(--dark-surface-2)] text-[11px] uppercase text-[color:var(--dark-text-dim)] font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama Formula</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Deskripsi</th>
                                <th class="px-6 py-4">Harga/ml</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--dark-border)] bg-[color:var(--dark-surface)]">
                            @forelse($semua_formula as $formula)
                                <tr class="item-formula hover:bg-[color:var(--dark-surface-2)] transition"
                                    data-search="{{ strtolower($formula->nama_formula . ' ' . $formula->kategori) }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-data text-[color:var(--dark-text)]">{{ $formula->nama_formula }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[color:var(--dark-text-dim)]">{{ $formula->kategori ?? '-' }}</td>
                                    <td class="px-6 py-4 text-[color:var(--dark-text-dim)] max-w-xs truncate">{{ $formula->deskripsi ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-data text-[color:var(--dark-text)]">Rp {{ number_format($formula->harga_per_ml, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <button type="button"
                                                onclick="document.getElementById('modal-edit-{{ $formula->formula_id }}').classList.add('active')"
                                                class="bg-blue-500/10 hover:bg-blue-500/20 text-blue-300 text-xs font-bold py-2 px-3 rounded-lg border border-blue-500/30 transition inline-flex items-center gap-1.5">
                                                <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.formula.destroy', $formula->formula_id) }}" method="POST" onsubmit="return confirm('Hapus formula aroma {{ $formula->nama_formula }}? Data komposisi pesanan lama yang memakai formula ini bisa terpengaruh.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs font-bold py-2 px-3 rounded-lg border border-red-500/30 transition inline-flex items-center gap-1.5">
                                                    <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-[color:var(--dark-text-faint)] font-medium">
                                        Belum ada data formula aroma. Tambahkan lewat form di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TAMPILAN KARTU GRID (horizontal, persegi) --}}
            <div id="view-grid-formula" class="view-grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @forelse($semua_formula as $formula)
                    <div class="item-formula bg-[color:var(--dark-surface)] rounded-2xl border border-[color:var(--dark-border)] shadow-md p-5 flex flex-col justify-between aspect-square"
                        data-search="{{ strtolower($formula->nama_formula . ' ' . $formula->kategori) }}">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-full bg-gold-soft border border-gold/30 flex items-center justify-center">
                                <svg class="icon w-4.5 h-4.5 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6M10 3v6.5L4.5 19a1.5 1.5 0 001.3 2.2h12.4a1.5 1.5 0 001.3-2.2L14 9.5V3"/></svg>
                            </div>
                            <div class="font-data text-[color:var(--dark-text)] text-sm truncate">{{ $formula->nama_formula }}</div>
                            @if($formula->kategori)
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-purple-500/10 text-purple-300 border border-purple-500/30">{{ $formula->kategori }}</span>
                            @endif
                            <div class="text-xs text-[color:var(--dark-text-faint)] truncate">{{ $formula->deskripsi ?? '-' }}</div>
                            <div class="font-data text-[color:var(--dark-text)] text-sm">Rp {{ number_format($formula->harga_per_ml, 0, ',', '.') }} <span class="text-xs font-normal text-[color:var(--dark-text-faint)]">/ml</span></div>
                        </div>
                        <div class="flex items-center gap-2 pt-3 border-t border-[color:var(--dark-border)] mt-3">
                            <button type="button"
                                onclick="document.getElementById('modal-edit-{{ $formula->formula_id }}').classList.add('active')"
                                class="flex-1 bg-blue-500/10 hover:bg-blue-500/20 text-blue-300 text-[11px] font-bold py-1.5 rounded-lg border border-blue-500/30 transition inline-flex items-center justify-center gap-1">
                                <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </button>
                            <form action="{{ route('admin.formula.destroy', $formula->formula_id) }}" method="POST" onsubmit="return confirm('Hapus formula aroma {{ $formula->nama_formula }}?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 text-[11px] font-bold py-1.5 rounded-lg border border-red-500/30 transition inline-flex items-center justify-center gap-1">
                                    <svg class="icon w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-[color:var(--dark-text-faint)] font-medium bg-[color:var(--dark-surface)] rounded-2xl border border-[color:var(--dark-border)]">
                        Belum ada data formula aroma. Tambahkan lewat form di atas.
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <footer class="text-center py-6 text-xs uppercase tracking-widest text-[color:var(--dark-text-faint)] bg-[#191620] border-t border-[color:var(--dark-border)]">
        &copy; {{ date('Y') }} E-Blend Parfume Admin Panel.
    </footer>

    {{-- ================= MODALS (diletakkan di luar tabel/grid agar HTML valid) ================= --}}

    {{-- Modal Bukti Pembayaran --}}
    @foreach($semua_pesanan as $pesanan)
        @if($pesanan->pembayaran && $pesanan->pembayaran->bukti_pembayaran)
            <div id="modal-bukti-{{ $pesanan->pesanan_id }}" class="modal-overlay">
                <div class="bg-[color:var(--dark-surface)] rounded-2xl shadow-2xl border border-[color:var(--dark-border)] max-w-lg w-full mx-4 overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-[color:var(--dark-border)]">
                        <h3 class="font-display text-lg font-semibold text-[color:var(--dark-text)]">Bukti Pembayaran — {{ $pesanan->pesanan_id }}</h3>
                        <button onclick="document.getElementById('modal-bukti-{{ $pesanan->pesanan_id }}').classList.remove('active')" class="text-[color:var(--dark-text-faint)] hover:text-[color:var(--dark-text)] text-xl leading-none">&times;</button>
                    </div>
                    <div class="p-6 space-y-3">
                        <img src="{{ asset('storage/' . $pesanan->pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-full rounded-xl border border-[color:var(--dark-border)] shadow-sm">
                        <div class="text-sm text-[color:var(--dark-text-dim)] space-y-1 pt-2">
                            <p><span class="font-semibold text-[color:var(--dark-text)]">Metode:</span> {{ $pesanan->pembayaran->metode_pembayaran ?? '-' }}</p>
                            <p><span class="font-semibold text-[color:var(--dark-text)]">Jumlah Bayar:</span> Rp {{ number_format($pesanan->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                            <p><span class="font-semibold text-[color:var(--dark-text)]">Tanggal Bayar:</span> {{ $pesanan->pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pesanan->pembayaran->tanggal_bayar)->translatedFormat('d M Y, H:i') : '-' }}</p>
                            <p><span class="font-semibold text-[color:var(--dark-text)]">Status Verifikasi:</span> {{ $pesanan->pembayaran->status_pembayaran ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Modal Edit Formula --}}
    @foreach($semua_formula as $formula)
        <div id="modal-edit-{{ $formula->formula_id }}" class="modal-overlay">
            <div class="bg-[color:var(--dark-surface)] rounded-2xl shadow-2xl border border-[color:var(--dark-border)] max-w-lg w-full mx-4 overflow-hidden">
                <div class="flex justify-between items-center px-6 py-4 border-b border-[color:var(--dark-border)]">
                    <h3 class="font-display text-lg font-semibold text-[color:var(--dark-text)]">Edit Formula — {{ $formula->nama_formula }}</h3>
                    <button onclick="document.getElementById('modal-edit-{{ $formula->formula_id }}').classList.remove('active')" class="text-[color:var(--dark-text-faint)] hover:text-[color:var(--dark-text)] text-xl leading-none">&times;</button>
                </div>
                <form action="{{ route('admin.formula.update', $formula->formula_id) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Nama Formula</label>
                        <input type="text" name="nama_formula" value="{{ $formula->nama_formula }}" required class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] focus:border-gold outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Kategori</label>
                        <input type="text" name="kategori" value="{{ $formula->kategori }}" class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] focus:border-gold outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ $formula->deskripsi }}" class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] focus:border-gold outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[color:var(--dark-text-dim)] uppercase mb-1">Harga per ml (Rp)</label>
                        <input type="number" step="0.01" min="0" name="harga_per_ml" value="{{ $formula->harga_per_ml }}" required class="w-full p-2.5 rounded-lg border border-[color:var(--dark-border)] bg-[color:var(--dark-surface-2)] text-[color:var(--dark-text)] focus:border-gold outline-none text-sm">
                    </div>
                    <button type="submit" class="w-full accent-purple hover:bg-[#FF6B86] text-white font-bold text-sm py-2.5 rounded-xl transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        // Tutup modal kalau klik area gelap di luar konten
        document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
        });

        // ===== Toggle Tampilan: Tabel (vertikal) <-> Kartu Grid (horizontal persegi) =====
        document.querySelectorAll('.view-toggle-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const target = this.getAttribute('data-target'); // pesanan | customer | formula
                const view = this.getAttribute('data-view');     // table | grid

                // Update tombol aktif
                document.querySelectorAll('.view-toggle-btn[data-target="' + target + '"]').forEach(function (b) {
                    b.classList.remove('active');
                    b.classList.add('text-[color:var(--dark-text-dim)]');
                });
                this.classList.add('active');
                this.classList.remove('text-[color:var(--dark-text-dim)]');

                // Tampilkan/sembunyikan container yang sesuai
                const tableEl = document.getElementById('view-table-' + target);
                const gridEl = document.getElementById('view-grid-' + target);

                if (view === 'grid') {
                    tableEl.classList.add('hidden-view');
                    gridEl.classList.add('active');
                } else {
                    tableEl.classList.remove('hidden-view');
                    gridEl.classList.remove('active');
                }
            });
        });

        // ===== Fitur search sederhana — Customer & Formula (berlaku di tabel & kartu sekaligus) =====
        function setupSimpleSearch(inputId, itemClass) {
            const input = document.getElementById(inputId);
            if (!input) return;

            input.addEventListener('keyup', function () {
                const keyword = this.value.trim().toLowerCase();
                document.querySelectorAll('.' + itemClass).forEach(function (item) {
                    const haystack = item.getAttribute('data-search') || '';
                    item.style.display = haystack.includes(keyword) ? '' : 'none';
                });
            });
        }

        setupSimpleSearch('search-customer', 'item-customer');
        setupSimpleSearch('search-formula', 'item-formula');

        // ===== Fitur khusus Pesanan: search + filter status + sort terbaru/terlama + sorot belum dibayar =====
        // Berlaku untuk tabel & kartu grid sekaligus
        (function () {
            const searchInput = document.getElementById('search-pesanan');
            const statusFilter = document.getElementById('filter-status-pesanan');
            const sortBtn = document.getElementById('sort-pesanan-btn');
            const quickUnpaidBtn = document.getElementById('quick-unpaid-btn');
            if (!searchInput || !statusFilter || !sortBtn) return;

            function applyFilters() {
                const keyword = searchInput.value.trim().toLowerCase();
                const status = statusFilter.value;

                document.querySelectorAll('.item-pesanan').forEach(function (item) {
                    const haystack = item.getAttribute('data-search') || '';
                    const itemStatus = item.getAttribute('data-status') || '';

                    const matchesKeyword = haystack.includes(keyword);
                    const matchesStatus = !status || itemStatus === status;

                    item.style.display = (matchesKeyword && matchesStatus) ? '' : 'none';
                });
            }

            function sortItems(containerId) {
                const order = sortBtn.getAttribute('data-order');
                const container = document.getElementById(containerId);
                if (!container) return;

                const parent = container.tagName === 'TABLE' ? container.querySelector('tbody') : container;
                const items = Array.from(parent.children).filter(function (el) {
                    return el.classList.contains('item-pesanan');
                });

                items.sort(function (a, b) {
                    const aTime = parseInt(a.getAttribute('data-created') || '0', 10);
                    const bTime = parseInt(b.getAttribute('data-created') || '0', 10);
                    return order === 'desc' ? bTime - aTime : aTime - bTime;
                });

                items.forEach(function (item) { parent.appendChild(item); });
            }

            function sortAllViews() {
                sortItems('table-pesanan');
                sortItems('view-grid-pesanan');
            }

            searchInput.addEventListener('keyup', applyFilters);
            statusFilter.addEventListener('change', applyFilters);

            const sortIcon = document.getElementById('sort-icon');
            const sortLabel = document.getElementById('sort-label');

            sortBtn.addEventListener('click', function () {
                const next = this.getAttribute('data-order') === 'desc' ? 'asc' : 'desc';
                this.setAttribute('data-order', next);
                if (sortLabel) sortLabel.textContent = next === 'desc' ? 'Terbaru' : 'Terlama';
                if (sortIcon) sortIcon.style.transform = next === 'desc' ? 'rotate(0deg)' : 'rotate(180deg)';
                sortAllViews();
            });

            if (quickUnpaidBtn) {
                quickUnpaidBtn.addEventListener('click', function () {
                    statusFilter.value = statusFilter.value === 'Menunggu Pembayaran' ? '' : 'Menunggu Pembayaran';
                    applyFilters();
                });
            }
        })();
    </script>

</body>
</html>