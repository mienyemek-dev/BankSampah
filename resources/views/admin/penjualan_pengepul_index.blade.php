<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan ke Pengepul / Pabrik - Panel Admin</title>
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
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <span>🏭</span> Penjualan Sampah Press ke Pengepul / Pabrik
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Catat pengiriman muatan komoditas press ke pabrik rekanan dan pencatatan kas masuk bank sampah</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.stok_sampah') }}" class="px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs rounded-xl border border-emerald-300 transition flex items-center gap-1.5 shadow-sm">
                    <span>📦</span> Lihat Stok Gudang Depo
                </a>
            </div>
        </div>

        <div class="p-8 max-w-7xl">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6 shadow-sm">
                    <span>✅</span><span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-2 mb-6 shadow-sm">
                    <span>⚠️</span><span class="font-semibold">{{ session('error') }}</span>
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

            {{-- 3 Kartu Ringkasan KPI Penjualan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl flex-shrink-0">
                        💰
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Kas Masuk Terkumpul</p>
                        <p class="text-2xl font-black text-emerald-700 mt-0.5">
                            Rp {{ number_format($totalPenjualanSukses, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Hasil penjualan riil ke pabrik</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl flex-shrink-0">
                        ⚖️
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Tonase Terjual</p>
                        <p class="text-2xl font-black text-blue-700 mt-0.5">
                            {{ number_format($totalBeratTerjual, 1, ',', '.') }} <span class="text-xs font-semibold text-slate-500">Kg/Satuan</span>
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Muatan keluar dari depo</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl flex-shrink-0">
                        📦
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sisa Stok Fisik Gudang</p>
                        <p class="text-2xl font-black text-slate-800 mt-0.5">
                            {{ number_format($totalStokKg, 1, ',', '.') }} <span class="text-xs font-semibold text-slate-500">Kg</span>
                        </p>
                        <a href="{{ route('admin.stok_sampah') }}" class="text-[11px] text-emerald-600 font-bold hover:underline mt-0.5 inline-block">
                            Cek Rincian Inventori Depo →
                        </a>
                    </div>
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
                            <h2 class="text-sm font-bold text-slate-800">Form Pengiriman ke Pabrik</h2>
                            <p class="text-xs text-slate-500">Kirim muatan komoditas & catat kas masuk</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.penjualan_pengepul.store') }}" id="formPenjualan" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Pabrik / Pengepul <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_pabrik_pengepul" placeholder="Contoh: PT Daur Ulang Mandiri / CV Berkah Jaya" required
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
                                        data-satuan="{{ $s->satuan }}"
                                        {{ (old('id_sampah', $selectedSampahId) == $s->id_sampah) ? 'selected' : '' }}>
                                        {{ $s->nama_sampah }} (Sisa Stok: {{ number_format($s->stok_saat_ini, 1, ',', '.') }} {{ $s->satuan }})
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
                                <input type="number" step="0.1" min="0.1" name="berat_jual" id="beratJual" value="{{ old('berat_jual') }}" oninput="calcTotal()" required
                                    placeholder="0.0"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                                <p id="errStok" class="text-[11px] font-bold text-rose-500 mt-1 hidden"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1 flex items-center justify-between">
                                    <span>Harga Pabrik (Rp) *</span>
                                    <span class="text-[10px] text-emerald-600 font-semibold">Bisa Nego</span>
                                </label>
                                <input type="number" step="50" min="1" name="harga_jual_satuan" id="hargaJual" value="{{ old('harga_jual_satuan', 0) }}" oninput="calcTotal()" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-500 leading-relaxed">
                            💡 <b>Kenapa Harga Pabrik Bisa Diatur?</b><br>
                            Harga otomatis terisi dari <i>Master Harga</i> sebagai patokan standar. Namun, karena harga pabrik di lapangan sering fluktuatif mengikuti grade/kadar air dan negosiasi tonase, staf dapat menyesuaikan nominal harga per kilogramnya sesuai kesepakatan nota pabrik.
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Pengiriman (Opsional)</label>
                            <input type="text" name="catatan" placeholder="Nomor polisi truk / nama sopir pengangkut..."
                                value="{{ old('catatan') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div class="p-4 bg-emerald-50 rounded-xl flex items-center justify-between border border-emerald-200">
                            <div>
                                <p class="text-[11px] text-slate-500 uppercase font-bold">Total Kas Masuk</p>
                                <p class="text-xs text-emerald-800 font-semibold">Masuk ke kas Bank Sampah</p>
                            </div>
                            <span class="text-lg font-black text-emerald-700" id="totalPendapatan">Rp 0</span>
                        </div>

                        <button type="submit" id="btnSubmitJual" class="w-full py-3 bg-blue-600 hover:bg-blue-700 active:scale-[0.99] text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                            <span id="btnIconJual">💾</span>
                            <span id="btnTextJual">Simpan & Masukkan ke Kas</span>
                        </button>
                    </form>
                </div>

                {{-- Riwayat Penjualan --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Riwayat Pengiriman & Penjualan ke Pabrik</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Catatan transaksi muatan keluar dari depo ke pabrik rekanan</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                                <tr>
                                    <th class="p-3.5">Kode & Tanggal</th>
                                    <th class="p-3.5">Pabrik Tujuan</th>
                                    <th class="p-3.5">Komoditas & Muatan</th>
                                    <th class="p-3.5 text-right">Kas Masuk (Rp)</th>
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
                                            <p class="text-xs text-slate-400 mt-1">Gunakan form di samping untuk mencatat transaksi penjualan muatan ke pabrik</p>
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
            if (!opt) return;

            const harga = opt.getAttribute('data-harga') || 0;
            const stok  = parseFloat(opt.getAttribute('data-stok')) || 0;
            const satuan = opt.getAttribute('data-satuan') || 'Kg';

            currentAvailableStock = stok;
            
            // Hanya update harga jika input belum diisi user atau bernilai 0
            const hargaInput = document.getElementById('hargaJual');
            if (!hargaInput.value || parseFloat(hargaInput.value) === 0) {
                hargaInput.value = harga;
            }

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

        function calcTotal() {
            const beratInput = document.getElementById('beratJual');
            const qty   = parseFloat(beratInput.value) || 0;
            const price = parseFloat(document.getElementById('hargaJual').value) || 0;
            const errEl = document.getElementById('errStok');
            const btn   = document.getElementById('btnSubmitJual');
            const sel   = document.getElementById('selectSampah');
            const satuan = sel.options[sel.selectedIndex]?.getAttribute('data-satuan') || 'Kg';

            // Validasi apakah melebihi stok yang ada
            if (sel.value && qty > currentAvailableStock) {
                errEl.innerText = `❌ Melebihi stok! Maksimal yang tersedia di depo: ${currentAvailableStock.toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 })} ${satuan}`;
                errEl.classList.remove('hidden');
                beratInput.classList.add('border-rose-500', 'bg-rose-50');
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                errEl.classList.add('hidden');
                beratInput.classList.remove('border-rose-500', 'bg-rose-50');
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }

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

        // Trigger on initial load (misal redirect dengan ?id_sampah=...)
        document.addEventListener('DOMContentLoaded', function() {
            const sel = document.getElementById('selectSampah');
            if (sel.value) {
                onSampahChange();
            }
        });
    </script>
</body>
</html>