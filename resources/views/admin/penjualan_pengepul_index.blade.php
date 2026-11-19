<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventori Gudang & Penjualan ke Pengepul - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'penjualan'])

    <main class="flex-1 overflow-y-auto">
        {{-- Header Topbar --}}
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">🏭 Inventori Gudang & Penjualan ke Pengepul / Pabrik</h1>
                <p class="text-xs text-slate-500 mt-0.5">Monitoring stok sampah hasil timbangan warga dan catat penjualan komoditas press ke pabrik</p>
            </div>
            <span class="text-xs bg-emerald-50 text-emerald-800 font-bold px-3 py-1.5 rounded-full border border-emerald-200 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Stok Real-time Terkoneksi
            </span>
        </div>

        <div class="p-8 max-w-7xl">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6 shadow-sm">
                    <span>✅</span><span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm mb-6 shadow-sm">
                    <div class="font-bold flex items-center gap-1.5 mb-1.5">
                        <span>⚠️</span><span>Mohon periksa data penjualan:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 3 Kartu Ringkasan KPI --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl">
                        📦
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Stok di Gudang</p>
                        <p class="text-2xl font-black text-slate-800 mt-0.5">
                            {{ number_format($totalStokKg, 1, ',', '.') }} <span class="text-sm font-semibold text-slate-500">Kg/Satuan</span>
                        </p>
                        <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">Siap dijual ke pabrik pengepul</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl">
                        💎
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Potensi Kas Masuk</p>
                        <p class="text-2xl font-black text-emerald-700 mt-0.5">
                            Rp {{ number_format($totalEstimasiPendapatan, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Taksiran nilai jika semua stok terjual</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl">
                        🏭
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Terjual ke Pabrik</p>
                        <p class="text-2xl font-black text-blue-700 mt-0.5">
                            Rp {{ number_format($totalPenjualanSukses, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Total tonase keluar: {{ number_format($totalBeratTerjual, 0, ',', '.') }} Kg</p>
                    </div>
                </div>
            </div>

            {{-- Tabel Inventori Stok Gudang Depo (Real-Time) --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <span>📊</span> Inventori Stok Sampah Depo Saat Ini
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Data terhitung otomatis dari: (Total Setoran Timbangan Nasabah) dikurangi (Total Penjualan ke Pabrik)</p>
                    </div>
                    <span class="text-xs text-slate-500 font-medium bg-slate-100 px-3 py-1 rounded-lg">
                        {{ $sampahList->count() }} Jenis Komoditas
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3.5">Komoditas Sampah</th>
                                <th class="p-3.5">Kategori</th>
                                <th class="p-3.5 text-right">Total Masuk</th>
                                <th class="p-3.5 text-right">Total Terjual</th>
                                <th class="p-3.5 text-center">Sisa Stok di Depo</th>
                                <th class="p-3.5 text-right">Harga Jual Pabrik</th>
                                <th class="p-3.5 text-right">Estimasi Nilai</th>
                                <th class="p-3.5 text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($sampahList as $s)
                                <tr class="hover:bg-slate-50 transition" id="row-sampah-{{ $s->id_sampah }}">
                                    <td class="p-3.5 font-bold text-slate-800">
                                        {{ $s->nama_sampah }}
                                    </td>
                                    <td class="p-3.5 text-slate-500">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600">
                                            {{ $s->kategori->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-right font-medium text-slate-600">
                                        {{ number_format($s->total_masuk, 1, ',', '.') }} {{ $s->satuan }}
                                    </td>
                                    <td class="p-3.5 text-right font-medium text-slate-400">
                                        {{ number_format($s->total_keluar, 1, ',', '.') }} {{ $s->satuan }}
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if ($s->stok_saat_ini > 20)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                                                <span>🟢</span> {{ number_format($s->stok_saat_ini, 1, ',', '.') }} {{ $s->satuan }}
                                            </span>
                                        @elseif ($s->stok_saat_ini > 0)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                <span>🟡</span> {{ number_format($s->stok_saat_ini, 1, ',', '.') }} {{ $s->satuan }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-400">
                                                <span>⚪</span> 0 {{ $s->satuan }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-right font-semibold text-slate-700">
                                        Rp {{ number_format($s->harga_jual_pengepul, 0, ',', '.') }}/{{ $s->satuan }}
                                    </td>
                                    <td class="p-3.5 text-right font-black text-emerald-700">
                                        Rp {{ number_format($s->estimasi_nilai, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <button type="button" 
                                            onclick="selectForSale({{ $s->id_sampah }}, '{{ addslashes($s->nama_sampah) }}', {{ $s->harga_jual_pengepul }}, {{ $s->stok_saat_ini }}, '{{ $s->satuan }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm {{ $s->stok_saat_ini > 0 ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-slate-200 text-slate-400 cursor-not-allowed' }}">
                                            Jual Ini →
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Form Penjualan & Riwayat --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                {{-- Form Input Penjualan --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-24" id="formSection">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl">
                            🏭
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Form Penjualan ke Pabrik</h2>
                            <p class="text-xs text-slate-500">Kirim muatan sampah press & terima kas</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.penjualan_pengepul.store') }}" id="formPenjualan" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Pabrik / Pengepul <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_pabrik_pengepul" placeholder="Contoh: PT Daur Ulang Mandiri / Bos Pengepul Joko" required
                                value="{{ old('nama_pabrik_pengepul') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Pengiriman <span class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal_penjualan" value="{{ old('tanggal_penjualan', date('Y-m-d')) }}" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Komoditas yang Dijual <span class="text-rose-500">*</span></label>
                            <select name="id_sampah" required id="selectSampah" onchange="onSampahChange()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="" data-harga="0" data-stok="0" data-satuan="Kg">-- Pilih Komoditas --</option>
                                @foreach ($sampahList as $s)
                                    <option value="{{ $s->id_sampah }}" 
                                        data-harga="{{ $s->harga_jual_pengepul }}"
                                        data-stok="{{ $s->stok_saat_ini }}"
                                        data-satuan="{{ $s->satuan }}">
                                        {{ $s->nama_sampah }} (Stok: {{ number_format($s->stok_saat_ini, 1, ',', '.') }} {{ $s->satuan }})
                                    </option>
                                @endforeach
                            </select>

                            {{-- Badge info stok real-time terpilih --}}
                            <div id="stockBadgeContainer" class="mt-2 hidden">
                                <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between">
                                    <span class="text-[11px] font-semibold text-amber-900">
                                        📦 Stok Tersedia: <b id="lblStok" class="font-extrabold">0 Kg</b>
                                    </span>
                                    <button type="button" onclick="fillAllStock()" class="text-[10px] font-bold text-emerald-700 hover:text-emerald-800 underline">
                                        Jual Semua Stok
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Berat Dijual (<span id="lblUnit">Kg</span>) <span class="text-rose-500">*</span></label>
                                <input type="number" step="0.1" min="0.1" name="berat_jual" id="beratJual" value="" oninput="calcTotal()" required
                                    placeholder="0.0"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Harga Pabrik (Rp) <span class="text-rose-500">*</span></label>
                                <input type="number" step="50" min="1" name="harga_jual_satuan" id="hargaJual" value="0" oninput="calcTotal()" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Pengiriman (Opsional)</label>
                            <input type="text" name="catatan" placeholder="Nomor truk / sopir pengangkut..."
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div class="p-4 bg-emerald-50 rounded-xl flex items-center justify-between border border-emerald-200">
                            <div>
                                <p class="text-[11px] text-slate-500 uppercase font-bold">Total Nilai Kas Masuk</p>
                                <p class="text-xs text-emerald-800 font-semibold">Otomatis masuk kas bank sampah</p>
                            </div>
                            <span class="text-lg font-black text-emerald-700" id="totalPendapatan">Rp 0</span>
                        </div>

                        <button type="submit" id="btnSubmitJual" class="w-full py-3 bg-blue-600 hover:bg-blue-700 active:scale-[0.99] text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                            <span id="btnIconJual">💾</span>
                            <span id="btnTextJual">Simpan Transaksi Penjualan</span>
                        </button>
                    </form>
                </div>

                {{-- Riwayat Penjualan --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Riwayat Pengiriman & Penjualan ke Pabrik</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pencatatan pendapatan riil kas Bank Sampah dari penjualan komoditas</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                                <tr>
                                    <th class="p-3.5">Kode & Tanggal</th>
                                    <th class="p-3.5">Pabrik Tujuan</th>
                                    <th class="p-3.5">Komoditas & Muatan</th>
                                    <th class="p-3.5 text-right">Pendapatan Bersih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($penjualanList as $sls)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="p-3.5">
                                            <span class="font-mono font-bold text-blue-700">{{ $sls->kode_penjualan }}</span>
                                            <p class="text-[11px] text-slate-400">{{ $sls->tanggal_penjualan->format('d M Y') }}</p>
                                        </td>
                                        <td class="p-3.5">
                                            <p class="font-bold text-slate-800">{{ $sls->nama_pabrik_pengepul }}</p>
                                            @if ($sls->catatan)
                                                <p class="text-[11px] text-slate-400 italic">"{{ $sls->catatan }}"</p>
                                            @endif
                                        </td>
                                        <td class="p-3.5">
                                            @foreach ($sls->details as $d)
                                                <p class="text-slate-800 font-semibold">{{ $d->sampah->nama_sampah ?? 'Sampah' }}</p>
                                                <p class="text-[11px] text-slate-500">{{ number_format($d->berat_satuan, 1, ',', '.') }} Kg × Rp {{ number_format($d->harga_jual_satuan, 0, ',', '.') }}</p>
                                            @endforeach
                                        </td>
                                        <td class="p-3.5 text-right font-black text-emerald-700 text-sm">
                                            Rp {{ number_format($sls->total_pendapatan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-12 text-center text-slate-400">
                                            <div class="text-4xl mb-2">🏭</div>
                                            <p class="font-bold text-slate-600">Belum ada catatan penjualan ke pabrik</p>
                                            <p class="text-xs text-slate-400 mt-1">Pilih komoditas dari tabel inventori di atas dan catat pengiriman pertama Anda</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($penjualanList->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100">
                            {{ $penjualanList->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </main>

    <script>
        let currentAvailableStock = 0;

        function onSampahChange() {
            const sel = document.getElementById('selectSampah');
            const opt = sel.options[sel.selectedIndex];
            const harga = opt.getAttribute('data-harga') || 0;
            const stok  = parseFloat(opt.getAttribute('data-stok')) || 0;
            const satuan = opt.getAttribute('data-satuan') || 'Kg';

            currentAvailableStock = stok;
            document.getElementById('hargaJual').value = harga;
            document.getElementById('lblUnit').innerText = satuan;

            const badgeContainer = document.getElementById('stockBadgeContainer');
            if (sel.value) {
                badgeContainer.classList.remove('hidden');
                document.getElementById('lblStok').innerText = stok.toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 }) + ' ' + satuan;
            } else {
                badgeContainer.classList.add('hidden');
            }

            calcTotal();
        }

        function fillAllStock() {
            if (currentAvailableStock > 0) {
                document.getElementById('beratJual').value = currentAvailableStock;
                calcTotal();
            }
        }

        function selectForSale(id, nama, harga, stok, satuan) {
            const sel = document.getElementById('selectSampah');
            sel.value = id;
            onSampahChange();

            // Isi berat langsung sesuai stok jika ada
            if (stok > 0) {
                document.getElementById('beratJual').value = stok;
            } else {
                document.getElementById('beratJual').value = '';
            }
            calcTotal();

            // Scroll mulus ke form
            document.getElementById('formSection').scrollIntoView({ behavior: 'smooth' });
        }

        function calcTotal() {
            const qty   = parseFloat(document.getElementById('beratJual').value) || 0;
            const price = parseFloat(document.getElementById('hargaJual').value) || 0;
            const total = qty * price;
            document.getElementById('totalPendapatan').innerText = 'Rp ' + Math.round(total).toLocaleString('id-ID');
        }

        document.getElementById('formPenjualan').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmitJual');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            document.getElementById('btnIconJual').innerText = '⏳';
            document.getElementById('btnTextJual').innerText = 'Menyimpan Transaksi...';
        });
    </script>
</body>
</html>
