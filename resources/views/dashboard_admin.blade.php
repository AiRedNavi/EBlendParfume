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
            <div class="flex justify-between items-center border-b border-gray-300 pb-3">
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">📦 Manajemen Pesanan Pelanggan</h2>
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">Total: {{ $semua_pesanan->count() }} Transaksi</span>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
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
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-gray-600">
                                        {{ $pesanan->pesanan_id }}
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

                                {{-- Modal Bukti Pembayaran (satu per pesanan) --}}
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
        </section>

        {{-- ================= SECTION: CUSTOMER ================= --}}
        <section id="section-customer" class="scroll-mt-28 space-y-6">
            <div class="flex justify-between items-center border-b border-gray-300 pb-3">
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">👥 Daftar Akun Customer</h2>
                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">Total: {{ $semua_customer->count() }} Customer</span>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
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
                                <tr class="hover:bg-gray-50 transition">
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
        </section>

        {{-- ================= SECTION: FORMULA AROMA ================= --}}
        <section id="section-formula" class="scroll-mt-28 space-y-6">
            <div class="flex justify-between items-center border-b border-gray-300 pb-3">
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
                        <input type="text" name="nama_formula" required class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kategori</label>
                        <input type="text" name="kategori" class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Harga per ml (Rp)</label>
                        <input type="number" step="0.01" min="0" name="harga_per_ml" required class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi</label>
                        <input type="text" name="deskripsi" class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-[#FF6BD0] outline-none text-sm">
                    </div>
                    <div class="md:col-span-4">
                        <button type="submit" class="accent-purple hover:bg-[#FF6B86] text-white font-bold text-sm py-2.5 px-6 rounded-xl transition">
                            + Tambah Formula
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
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
                                <tr class="hover:bg-gray-50 transition">
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

                                {{-- Modal Edit Formula --}}
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
        </section>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 bg-white border-t border-gray-200">
        &copy; {{ date('Y') }} E-Blend Parfume Admin Panel.
    </footer>

    <script>
        // Tutup modal kalau klik area gelap di luar konten
        document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
        });
    </script>

</body>
</html>