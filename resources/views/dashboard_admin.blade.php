<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | E-Blend Parfume</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #F3F4F6; color: #1F2937; }
        .accent-purple { background-color: #FF6BD0; }
        .accent-pink { background-color: #FF6B86; }
        .text-purple { color: #FF6BD0; }
        .border-pink { border-color: #FF6B86; }
        .nav-link { cursor: pointer; }
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 50;
            align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .view-toggle-btn.active {
            background-color: #1F2937;
            color: #FFFFFF;
        }
        .view-grid { display: none; }
        .view-grid.active { display: grid; }
        .view-table.hidden-view { display: none; }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col justify-between">

    <header class="bg-white shadow-sm py-5 px-8 flex flex-col sm:flex-row justify-between items-center border-b-4 border-purple gap-4">
        <a href="/" class="text-2xl font-bold tracking-wider text-black">E<span class="text-purple">-Blend Admin</span></a>

        <nav class="flex items-center gap-5 flex-wrap justify-center">
            <a href="#section-pesanan" class="nav-link text-sm font-semibold text-gray-600 hover:text-[#FF6B86] transition">📦 Pesanan</a>
            <a href="#section-customer" class="nav-link text-sm font-semibold text-gray-600 hover:text-[#FF6B86] transition">👥 Customer</a>
            <a href="#section-formula" class="nav-link text-sm font-semibold text-gray-600 hover:text-[#FF6B86] transition">🧪 Formula Aroma</a>
        </nav>

        <div class="flex items-center gap-4">
            <span class="text-sm font-semibold text-gray-600">Halo, {{ Auth::user()->nama }} (🔑 Admin)</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-500 hover:text-red-600 transition">Keluar</button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12 flex-1 w-full space-y-16">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline font-medium">✨ {{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl font-semibold shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ================= SECTION: PESANAN ================= --}}
        <section id="section-pesanan" class="scroll-mt-28 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-300 pb-3 gap-3">
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">📦 Manajemen Pesanan Pelanggan</h2>
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">Total: {{ $semua_pesanan->count() }} Transaksi</span>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 flex-wrap">
                <div class="relative w-full sm:w-72">
                    <input type="text" id="search-pesanan" placeholder="🔍 Cari ID pesanan atau nama pelanggan..."
                        class="w-full p-2.5 pl-4 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                </div>

                <select id="filter-status-pesanan" class="p-2.5 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm font-semibold text-gray-700">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Pembayaran">🔴 Belum Dibayar</option>
                    <option value="Pembayaran Dikirim">🔵 Perlu Cek Bukti</option>
                    <option value="Pesanan Diproses">🧪 Sedang Diracik</option>
                    <option value="Pesanan Selesai">🟢 Selesai</option>
                    <option value="Dibatalkan">⚪ Dibatalkan</option>
                </select>

                <button type="button" id="sort-pesanan-btn" data-order="desc"
                    class="p-2.5 rounded-xl border-2 border-gray-200 hover:border-[#FF6BD0] text-sm font-semibold text-gray-700 transition">
                    ⬇️ Terbaru
                </button>

                <button type="button" id="quick-unpaid-btn"
                    class="p-2.5 rounded-xl border-2 border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-bold transition">
                    🔴 Sorot Belum Dibayar
                </button>

                <div class="ml-0 sm:ml-auto flex items-center gap-1 bg-gray-100 rounded-xl p-1">
                    <button type="button" class="view-toggle-btn active text-xs font-bold px-3 py-2 rounded-lg transition" data-target="pesanan" data-view="table">
                        📋 Tabel
                    </button>
                    <button type="button" class="view-toggle-btn text-xs font-bold px-3 py-2 rounded-lg transition" data-target="pesanan" data-view="grid">
                        🔲 Kartu
                    </button>
                </div>
            </div>

            {{-- TAMPILAN TABEL --}}
            <div id="view-table-pesanan" class="view-table bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="table-pesanan" class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold tracking-wider">
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
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($semua_pesanan as $pesanan)
                                <tr class="item-pesanan hover:bg-gray-50 transition {{ $pesanan->status_pesanan === 'Menunggu Pembayaran' ? 'bg-amber-50/70 ring-1 ring-inset ring-amber-200' : '' }}"
                                    data-status="{{ $pesanan->status_pesanan }}"
                                    data-created="{{ optional($pesanan->created_at)->timestamp ?? 0 }}"
                                    data-search="{{ strtolower($pesanan->pesanan_id . ' ' . ($pesanan->user->nama ?? '')) }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-gray-600">
                                        {{ $pesanan->pesanan_id }}
                                        @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                            <span class="ml-1 text-amber-500" title="Belum dibayar">●</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">{{ $pesanan->user->nama ?? 'User Terhapus' }}</div>
                                        <div class="text-xs text-gray-500">ID User: {{ $pesanan->user_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                        Custom Botol ({{ $pesanan->ukuran_botol_ml }})
                                        <span class="block text-xs text-gray-400">Alkohol: {{ $pesanan->alkohol_ml }}ml</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pesanan->pembayaran && $pesanan->pembayaran->bukti_pembayaran)
                                            <button type="button"
                                                onclick="document.getElementById('modal-bukti-{{ $pesanan->pesanan_id }}').classList.add('active')"
                                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold py-2 px-3 rounded-lg border border-blue-200 transition">
                                                🖼️ Lihat Bukti
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum upload</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">🔴 Menunggu Bayar</span>
                                        @elseif($pesanan->status_pesanan === 'Pembayaran Dikirim')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">🔵 Perlu Cek Bukti</span>
                                        @elseif($pesanan->status_pesanan === 'Pesanan Diproses')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-800">🧪 Sedang Diracik</span>
                                        @elseif($pesanan->status_pesanan === 'Pesanan Selesai')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">🟢 Selesai</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800">⚪ {{ $pesanan->status_pesanan }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex items-center gap-4">
                                            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->pesanan_id) }}" method="POST" class="inline-flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status_pesanan" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg p-2 focus:ring-pink focus:border-pink">
                                                    <option value="Menunggu Pembayaran" {{ $pesanan->status_pesanan == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                                    <option value="Pembayaran Dikirim" {{ $pesanan->status_pesanan == 'Pembayaran Dikirim' ? 'selected' : '' }}>Pembayaran Dikirim</option>
                                                    <option value="Pesanan Diproses" {{ $pesanan->status_pesanan == 'Pesanan Diproses' ? 'selected' : '' }}>Diproses (Racik)</option>
                                                    <option value="Pesanan Selesai" {{ $pesanan->status_pesanan == 'Pesanan Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="Dibatalkan" {{ $pesanan->status_pesanan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                </select>
                                                <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold text-xs py-2 px-3 rounded-lg transition shadow-sm">
                                                    Simpan
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.pesanan.destroy', $pesanan->pesanan_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan {{ $pesanan->pesanan_id }} secara permanen? Tindakan ini tidak bisa dibatalkan!');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg border border-red-200 transition shadow-sm">
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
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-400 font-medium">
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
                    <div class="item-pesanan bg-white rounded-2xl border-2 {{ $pesanan->status_pesanan === 'Menunggu Pembayaran' ? 'border-amber-300' : 'border-gray-200' }} shadow-md p-5 flex flex-col justify-between aspect-square"
                        data-status="{{ $pesanan->status_pesanan }}"
                        data-created="{{ optional($pesanan->created_at)->timestamp ?? 0 }}"
                        data-search="{{ strtolower($pesanan->pesanan_id . ' ' . ($pesanan->user->nama ?? '')) }}">

                        <div class="space-y-2">
                            <div class="flex items-start justify-between">
                                <span class="font-mono font-bold text-xs text-gray-600 break-all">{{ $pesanan->pesanan_id }}</span>
                                @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                    <span class="text-amber-500 text-lg leading-none" title="Belum dibayar">●</span>
                                @endif
                            </div>
                            <div class="font-bold text-gray-900 text-sm truncate">{{ $pesanan->user->nama ?? 'User Terhapus' }}</div>
                            <div class="text-xs text-gray-500">Botol {{ $pesanan->ukuran_botol_ml }} • Alkohol {{ $pesanan->alkohol_ml }}ml</div>
                            <div class="font-bold text-gray-900 text-sm">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>

                            @if($pesanan->status_pesanan === 'Menunggu Pembayaran')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800">🔴 Menunggu Bayar</span>
                            @elseif($pesanan->status_pesanan === 'Pembayaran Dikirim')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-100 text-blue-800">🔵 Perlu Cek Bukti</span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Diproses')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-purple-100 text-purple-800">🧪 Diracik</span>
                            @elseif($pesanan->status_pesanan === 'Pesanan Selesai')
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-green-100 text-green-800">🟢 Selesai</span>
                            @else
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-800">⚪ {{ $pesanan->status_pesanan }}</span>
                            @endif
                        </div>

                        <div class="space-y-2 pt-3 border-t border-gray-100 mt-3">
                            @if($pesanan->pembayaran && $pesanan->pembayaran->bukti_pembayaran)
                                <button type="button"
                                    onclick="document.getElementById('modal-bukti-{{ $pesanan->pesanan_id }}').classList.add('active')"
                                    class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 text-[11px] font-bold py-1.5 rounded-lg border border-blue-200 transition">
                                    🖼️ Lihat Bukti
                                </button>
                            @endif

                            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->pesanan_id) }}" method="POST" class="flex items-center gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="status_pesanan" class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-[11px] rounded-lg p-1.5 focus:ring-pink focus:border-pink">
                                    <option value="Menunggu Pembayaran" {{ $pesanan->status_pesanan == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Pembayaran Dikirim" {{ $pesanan->status_pesanan == 'Pembayaran Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="Pesanan Diproses" {{ $pesanan->status_pesanan == 'Pesanan Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Pesanan Selesai" {{ $pesanan->status_pesanan == 'Pesanan Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Dibatalkan" {{ $pesanan->status_pesanan == 'Dibatalkan' ? 'selected' : '' }}>Batal</option>
                                </select>
                                <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold text-[11px] py-1.5 px-2 rounded-lg transition">
                                    ✓
                                </button>
                            </form>

                            <form action="{{ route('admin.pesanan.destroy', $pesanan->pesanan_id) }}" method="POST" onsubmit="return confirm('Hapus pesanan {{ $pesanan->pesanan_id }} secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-bold py-1.5 rounded-lg border border-red-200 transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-400 font-medium bg-white rounded-2xl border border-gray-200">
                        Belum ada data pesanan masuk dari pelanggan.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ================= SECTION: CUSTOMER ================= --}}
        <section id="section-customer" class="scroll-mt-28 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-300 pb-3 gap-3">
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">👥 Daftar Akun Customer</h2>
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">Total: {{ $semua_customer->count() }} Customer</span>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 flex-wrap">
                <div class="relative w-full sm:w-72">
                    <input type="text" id="search-customer" placeholder="🔍 Cari nama, email, atau no. HP..."
                        class="w-full p-2.5 pl-4 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                </div>

                <div class="ml-0 sm:ml-auto flex items-center gap-1 bg-gray-100 rounded-xl p-1">
                    <button type="button" class="view-toggle-btn active text-xs font-bold px-3 py-2 rounded-lg transition" data-target="customer" data-view="table">
                        📋 Tabel
                    </button>
                    <button type="button" class="view-toggle-btn text-xs font-bold px-3 py-2 rounded-lg transition" data-target="customer" data-view="grid">
                        🔲 Kartu
                    </button>
                </div>
            </div>

            {{-- TAMPILAN TABEL --}}
            <div id="view-table-customer" class="view-table bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="table-customer" class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">No. HP</th>
                                <th class="px-6 py-4">Alamat</th>
                                <th class="px-6 py-4 text-center">Jumlah Pesanan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($semua_customer as $customer)
                                <tr class="item-customer hover:bg-gray-50 transition"
                                    data-search="{{ strtolower($customer->nama . ' ' . $customer->email . ' ' . $customer->no_hp) }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $customer->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $customer->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $customer->no_hp ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $customer->alamat ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="bg-gray-100 text-gray-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $customer->pesanan_custom_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-medium">
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
                    <div class="item-customer bg-white rounded-2xl border-2 border-gray-200 shadow-md p-5 flex flex-col justify-between aspect-square"
                        data-search="{{ strtolower($customer->nama . ' ' . $customer->email . ' ' . $customer->no_hp) }}">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-full accent-purple flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($customer->nama, 0, 1)) }}
                            </div>
                            <div class="font-bold text-gray-900 text-sm truncate">{{ $customer->nama }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ $customer->email }}</div>
                            <div class="text-xs text-gray-500">{{ $customer->no_hp ?? '-' }}</div>
                            <div class="text-xs text-gray-400 truncate">{{ $customer->alamat ?? '-' }}</div>
                        </div>
                        <div class="pt-3 border-t border-gray-100 mt-3">
                            <span class="bg-gray-100 text-gray-700 text-[11px] font-bold px-2.5 py-1 rounded-full">{{ $customer->pesanan_custom_count }} Pesanan</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-400 font-medium bg-white rounded-2xl border border-gray-200">
                        Belum ada akun customer terdaftar.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ================= SECTION: FORMULA AROMA ================= --}}
        <section id="section-formula" class="scroll-mt-28 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-300 pb-3 gap-3">
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">🧪 Manajemen Formula Aroma</h2>
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">Total: {{ $semua_formula->count() }} Formula</span>
            </div>

            {{-- Form Tambah Formula --}}
            <div class="bg-white p-6 rounded-2xl border-2 border-pink shadow-md">
                <h3 class="font-bold text-gray-800 mb-4">Tambah Formula Aroma Baru</h3>
                <form action="{{ route('admin.formula.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Formula</label>
                        <input type="text" name="nama_formula" required placeholder="Honey, Cinnamon, Eucalyptus, etc..." class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kategori</label>
                        <input type="text" name="kategori" placeholder="Woody, Citrus, Floral, Nature, Sweet, etc..." class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Harga per ml (Rp)</label>
                        <input type="number" step="0.01" min="0" name="harga_per_ml" required placeholder="Rp3.000 - Rp12.000" class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" placeholder="Masukkan deskripsi formula..." class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
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
                    <input type="text" id="search-formula" placeholder="🔍 Cari nama formula atau kategori..."
                        class="w-full p-2.5 pl-4 rounded-xl border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                </div>

                <div class="ml-0 sm:ml-auto flex items-center gap-1 bg-gray-100 rounded-xl p-1">
                    <button type="button" class="view-toggle-btn active text-xs font-bold px-3 py-2 rounded-lg transition" data-target="formula" data-view="table">
                        📋 Tabel
                    </button>
                    <button type="button" class="view-toggle-btn text-xs font-bold px-3 py-2 rounded-lg transition" data-target="formula" data-view="grid">
                        🔲 Kartu
                    </button>
                </div>
            </div>

            {{-- TAMPILAN TABEL --}}
            <div id="view-table-formula" class="view-table bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="table-formula" class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama Formula</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Deskripsi</th>
                                <th class="px-6 py-4">Harga/ml</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($semua_formula as $formula)
                                <tr class="item-formula hover:bg-gray-50 transition"
                                    data-search="{{ strtolower($formula->nama_formula . ' ' . $formula->kategori) }}">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $formula->nama_formula }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $formula->kategori ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $formula->deskripsi ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">Rp {{ number_format($formula->harga_per_ml, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <button type="button"
                                                onclick="document.getElementById('modal-edit-{{ $formula->formula_id }}').classList.add('active')"
                                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold py-2 px-3 rounded-lg border border-blue-200 transition">
                                                ✏️ Edit
                                            </button>
                                            <form action="{{ route('admin.formula.destroy', $formula->formula_id) }}" method="POST" onsubmit="return confirm('Hapus formula aroma {{ $formula->nama_formula }}? Data komposisi pesanan lama yang memakai formula ini bisa terpengaruh.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold py-2 px-3 rounded-lg border border-red-200 transition">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-medium">
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
                    <div class="item-formula bg-white rounded-2xl border-2 border-gray-200 shadow-md p-5 flex flex-col justify-between aspect-square"
                        data-search="{{ strtolower($formula->nama_formula . ' ' . $formula->kategori) }}">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-lg">
                                🧪
                            </div>
                            <div class="font-bold text-gray-900 text-sm truncate">{{ $formula->nama_formula }}</div>
                            @if($formula->kategori)
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-purple-100 text-purple-700">{{ $formula->kategori }}</span>
                            @endif
                            <div class="text-xs text-gray-500 truncate">{{ $formula->deskripsi ?? '-' }}</div>
                            <div class="font-bold text-gray-900 text-sm">Rp {{ number_format($formula->harga_per_ml, 0, ',', '.') }} <span class="text-xs font-normal text-gray-400">/ml</span></div>
                        </div>
                        <div class="flex items-center gap-2 pt-3 border-t border-gray-100 mt-3">
                            <button type="button"
                                onclick="document.getElementById('modal-edit-{{ $formula->formula_id }}').classList.add('active')"
                                class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-[11px] font-bold py-1.5 rounded-lg border border-blue-200 transition">
                                ✏️ Edit
                            </button>
                            <form action="{{ route('admin.formula.destroy', $formula->formula_id) }}" method="POST" onsubmit="return confirm('Hapus formula aroma {{ $formula->nama_formula }}?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-bold py-1.5 rounded-lg border border-red-200 transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-400 font-medium bg-white rounded-2xl border border-gray-200">
                        Belum ada data formula aroma. Tambahkan lewat form di atas.
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 bg-white border-t border-gray-200">
        &copy; {{ date('Y') }} E-Blend Parfume Admin Panel.
    </footer>

    {{-- ================= MODALS (diletakkan di luar tabel/grid agar HTML valid) ================= --}}

    {{-- Modal Bukti Pembayaran --}}
    @foreach($semua_pesanan as $pesanan)
        @if($pesanan->pembayaran && $pesanan->pembayaran->bukti_pembayaran)
            <div id="modal-bukti-{{ $pesanan->pesanan_id }}" class="modal-overlay">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Bukti Pembayaran — {{ $pesanan->pesanan_id }}</h3>
                        <button onclick="document.getElementById('modal-bukti-{{ $pesanan->pesanan_id }}').classList.remove('active')" class="text-gray-400 hover:text-gray-700 text-xl leading-none">&times;</button>
                    </div>
                    <div class="p-6 space-y-3">
                        <img src="{{ asset('storage/' . $pesanan->pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-full rounded-xl border border-gray-200 shadow-sm">
                        <div class="text-sm text-gray-600 space-y-1 pt-2">
                            <p><span class="font-semibold text-gray-800">Metode:</span> {{ $pesanan->pembayaran->metode_pembayaran ?? '-' }}</p>
                            <p><span class="font-semibold text-gray-800">Jumlah Bayar:</span> Rp {{ number_format($pesanan->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                            <p><span class="font-semibold text-gray-800">Tanggal Bayar:</span> {{ $pesanan->pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pesanan->pembayaran->tanggal_bayar)->translatedFormat('d M Y, H:i') : '-' }}</p>
                            <p><span class="font-semibold text-gray-800">Status Verifikasi:</span> {{ $pesanan->pembayaran->status_pembayaran ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Modal Edit Formula --}}
    @foreach($semua_formula as $formula)
        <div id="modal-edit-{{ $formula->formula_id }}" class="modal-overlay">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 overflow-hidden">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Edit Formula — {{ $formula->nama_formula }}</h3>
                    <button onclick="document.getElementById('modal-edit-{{ $formula->formula_id }}').classList.remove('active')" class="text-gray-400 hover:text-gray-700 text-xl leading-none">&times;</button>
                </div>
                <form action="{{ route('admin.formula.update', $formula->formula_id) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Formula</label>
                        <input type="text" name="nama_formula" value="{{ $formula->nama_formula }}" required class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kategori</label>
                        <input type="text" name="kategori" value="{{ $formula->kategori }}" class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ $formula->deskripsi }}" class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Harga per ml (Rp)</label>
                        <input type="number" step="0.01" min="0" name="harga_per_ml" value="{{ $formula->harga_per_ml }}" required class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
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
                });
                this.classList.add('active');

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

            sortBtn.addEventListener('click', function () {
                const next = this.getAttribute('data-order') === 'desc' ? 'asc' : 'desc';
                this.setAttribute('data-order', next);
                this.textContent = next === 'desc' ? '⬇️ Terbaru' : '⬆️ Terlama';
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