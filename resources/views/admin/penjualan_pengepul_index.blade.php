<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan ke Pengepul - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'penjualan'])

    <main class="flex-1 overflow-y-auto">
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">🏭 Penjualan Sampah ke Pabrik / Pengepul</h1>
                <p class="text-xs text-slate-500 mt-0.5">Catat pemasukan kas riil dari pengiriman sampah press ke pabrik daur ulang</p>
            </div>
            <span class="text-xs bg-blue-100 text-blue-800 font-bold px-3 py-1.5 rounded-full border border-blue-200">
                💰 Siklus Kas Pemasukan Riil
            </span>
        </div>

        <div class="p-8">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6">
                    <span>✅</span><span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Form Input Penjualan --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-lg">🏭</div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Catat Penjualan Baru</h2>
                            <p class="text-xs text-slate-500">Sampah press ke pabrik daur ulang</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.penjualan_pengepul.store') }}" class="space-y-3.5">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Pabrik / Pengepul</label>
                            <input type="text" name="nama_pabrik_pengepul" placeholder="PT Daur Ulang Mandiri" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Penjualan</label>
                            <input type="date" name="tanggal_penjualan" value="{{ date('Y-m-d') }}" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Komoditas</label>
                            <select name="id_sampah" required id="selectSampah" onchange="autoFillPrice()"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="" data-harga="0">-- Pilih Komoditas --</option>
                                @foreach ($sampahList as $s)
                                    <option value="{{ $s->id_sampah }}" data-harga="{{ $s->harga_jual_pengepul }}">
                                        {{ $s->nama_sampah }} (Rp {{ number_format($s->harga_jual_pengepul, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Berat (Kg)</label>
                                <input type="number" step="1" min="1" name="berat_jual" id="beratJual" value="100" oninput="calcTotal()" required
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Harga/Kg (Rp)</label>
                                <input type="number" step="100" min="100" name="harga_jual_satuan" id="hargaJual" value="0" oninput="calcTotal()" required
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div class="p-3 bg-emerald-50 rounded-xl flex items-center justify-between border border-emerald-200">
                            <span class="text-xs text-slate-600 font-semibold">Total Nilai:</span>
                            <span class="text-base font-extrabold text-emerald-700" id="totalPendapatan">Rp 0</span>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">
                            💾 Simpan Penjualan
                        </button>
                    </form>
                </div>

                {{-- Riwayat Penjualan --}}
                <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800">Riwayat Pengiriman & Penjualan</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pencatatan pendapatan riil kas Bank Sampah</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                                <tr>
                                    <th class="p-3">Kode & Tanggal</th>
                                    <th class="p-3">Pabrik Tujuan</th>
                                    <th class="p-3">Komoditas & Berat</th>
                                    <th class="p-3 text-right">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($penjualanList as $sls)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="p-3">
                                            <span class="font-mono font-bold text-slate-800">{{ $sls->kode_penjualan }}</span>
                                            <p class="text-[11px] text-slate-400">{{ $sls->tanggal_penjualan->format('d M Y') }}</p>
                                        </td>
                                        <td class="p-3 font-semibold text-slate-700">{{ $sls->nama_pabrik_pengepul }}</td>
                                        <td class="p-3">
                                            @foreach ($sls->details as $d)
                                                <p class="text-slate-700 font-medium">{{ $d->sampah->nama_sampah ?? 'Sampah' }}</p>
                                                <p class="text-[11px] text-slate-400">{{ number_format($d->berat_satuan, 0) }} Kg × Rp {{ number_format($d->harga_jual_satuan, 0, ',', '.') }}</p>
                                            @endforeach
                                        </td>
                                        <td class="p-3 text-right font-extrabold text-emerald-700 text-sm">
                                            Rp {{ number_format($sls->total_pendapatan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400">
                                            <div class="text-3xl mb-2">🏭</div>
                                            <p class="font-semibold">Belum ada catatan penjualan ke pabrik</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $penjualanList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function autoFillPrice() {
            const sel = document.getElementById('selectSampah');
            document.getElementById('hargaJual').value = sel.options[sel.selectedIndex].getAttribute('data-harga') || 0;
            calcTotal();
        }
        function calcTotal() {
            const qty   = parseFloat(document.getElementById('beratJual').value) || 0;
            const price = parseFloat(document.getElementById('hargaJual').value) || 0;
            document.getElementById('totalPendapatan').innerText = 'Rp ' + (qty * price).toLocaleString('id-ID');
        }
    </script>
</body>
</html>
