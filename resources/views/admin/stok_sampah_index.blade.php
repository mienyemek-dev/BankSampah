<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok & Inventori Gudang Depo - Bank Sampah Bumi Sai Wawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'stok'])

    <main class="flex-1 overflow-y-auto">
        {{-- Header Topbar --}}
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <span>📦</span> Stok & Inventori Fisik Gudang Depo
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Monitoring kuota stok sampah terkumpul dari setoran warga dan siap didistribusikan ke pabrik rekanan</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.timbang') }}" class="px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs rounded-xl border border-emerald-300 transition flex items-center gap-1.5">
                    <span>⚖️</span> Timbang Masuk
                </a>
                <a href="{{ route('admin.penjualan_pengepul') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-700/20 transition flex items-center gap-1.5">
                    <span>🏭</span> Jual ke Pabrik →
                </a>
            </div>
        </div>

        <div class="p-8 max-w-7xl">

            {{-- 4 Kartu KPI Inventori --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl flex-shrink-0">
                        📦
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Fisik di Gudang</p>
                        <p class="text-2xl font-black text-slate-800 mt-0.5">
                            {{ number_format($totalStokKg, 1, ',', '.') }} <span class="text-xs font-semibold text-slate-500">Kg/Unit</span>
                        </p>
                        <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">Real-time dari depo</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl flex-shrink-0">
                        💎
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Valuasi Aset Sampah</p>
                        <p class="text-2xl font-black text-emerald-700 mt-0.5">
                            Rp {{ number_format($totalEstimasiPendapatan, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Estimasi nilai jual pabrik</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl flex-shrink-0">
                        🟢
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Komoditas Siap Jual</p>
                        <p class="text-2xl font-black text-blue-700 mt-0.5">
                            {{ $totalKomoditasTersedia }} <span class="text-xs font-semibold text-slate-500">Jenis</span>
                        </p>
                        <p class="text-[11px] text-blue-600 font-semibold mt-0.5">Stok > 0 tersedia</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center text-2xl flex-shrink-0">
                        ⚪
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Komoditas Kosong</p>
                        <p class="text-2xl font-black text-slate-700 mt-0.5">
                            {{ $totalKomoditasKosong }} <span class="text-xs font-semibold text-slate-500">Jenis</span>
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Belum ada stok masuk</p>
                    </div>
                </div>
            </div>

            {{-- Card Penjelasan Alur Kuota Stok --}}
            <div class="bg-gradient-to-r from-emerald-50 via-teal-50 to-blue-50 border border-emerald-200/80 rounded-2xl p-5 mb-8 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">💡</span>
                    <div>
                        <h3 class="text-xs font-bold text-emerald-950 uppercase tracking-wider">Bagaimana Alur Stok & Gudang Depo Bekerja?</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            <b>Stok Masuk:</b> Bertambah otomatis setiap kali admin melakukan penimbangan setoran nasabah di menu <i>Timbang & Setor</i>.<br>
                            <b>Stok Keluar:</b> Berkurang otomatis saat muatan sampah press dikirim dan dicatat di menu <i>Penjualan Pengepul</i>.<br>
                            <b>Kontrol Kuota:</b> Sistem membatasi penjualan agar tidak bisa menjual melebihi tonase fisik yang ada di gudang.
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.penjualan_pengepul') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition flex items-center gap-1.5 whitespace-nowrap">
                        <span>🏭</span> Buka Form Penjualan
                    </a>
                </div>
            </div>

            {{-- Tabel Rincian Inventori Gudang --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4 bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <span>📋</span> Rincian Stok Fisik Komoditas Depo
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar seluruh komoditas sampah yang terdata di sistem Bank Sampah</p>
                    </div>
                    
                    {{-- Pencarian Cepat --}}
                    <div class="w-full sm:w-64">
                        <input type="text" id="searchInput" oninput="filterTable()" placeholder="Cari nama komoditas..."
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs" id="tableInventori">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-4">Komoditas Sampah</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4 text-right">Total Masuk (Warga)</th>
                                <th class="p-4 text-right">Total Terjual (Pabrik)</th>
                                <th class="p-4 text-center">Sisa Stok Fisik</th>
                                <th class="p-4 text-right">Harga Jual Pabrik</th>
                                <th class="p-4 text-right">Valuasi Depo</th>
                                <th class="p-4 text-center">Aksi Distribusi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($sampahList as $s)
                                <tr class="hover:bg-slate-50 transition row-item">
                                    <td class="p-4 font-bold text-slate-800 commodity-name">
                                        {{ $s->nama_sampah }}
                                    </td>
                                    <td class="p-4 text-slate-500">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600">
                                            {{ $s->kategori->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right font-medium text-slate-600">
                                        {{ number_format($s->total_masuk, 1, ',', '.') }} {{ $s->satuan }}
                                    </td>
                                    <td class="p-4 text-right font-medium text-slate-400">
                                        {{ number_format($s->total_keluar, 1, ',', '.') }} {{ $s->satuan }}
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($s->stok_saat_ini > 20)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                                                <span>🟢</span> {{ number_format($s->stok_saat_ini, 1, ',', '.') }} {{ $s->satuan }}
                                            </span>
                                        @elseif ($s->stok_saat_ini > 0)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                <span>🟡</span> {{ number_format($s->stok_saat_ini, 1, ',', '.') }} {{ $s->satuan }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-400">
                                                <span>⚪</span> 0 {{ $s->satuan }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right font-semibold text-slate-700">
                                        Rp {{ number_format($s->harga_jual_pengepul, 0, ',', '.') }}/{{ $s->satuan }}
                                    </td>
                                    <td class="p-4 text-right font-black text-emerald-700">
                                        Rp {{ number_format($s->estimasi_nilai, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($s->stok_saat_ini > 0)
                                            <a href="{{ route('admin.penjualan_pengepul', ['id_sampah' => $s->id_sampah]) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white transition shadow-sm">
                                                <span>🏭</span> Jual ke Pabrik →
                                            </a>
                                        @else
                                            <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-400 cursor-not-allowed">
                                                Stok Kosong
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        function filterTable() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.row-item');
            rows.forEach(row => {
                const name = row.querySelector('.commodity-name').innerText.toLowerCase();
                if (name.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>