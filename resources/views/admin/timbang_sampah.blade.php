<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timbang & Setor Sampah - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'timbang'])

    <main class="flex-1 overflow-y-auto">
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">⚖️ Form Penimbangan & Setoran Sampah Warga</h1>
                <p class="text-xs text-slate-500 mt-0.5">Petugas: <span class="font-bold text-emerald-700">{{ Auth::user()->nama_lengkap }}</span></p>
            </div>
        </div>

        <div class="p-8 max-w-5xl">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6">
                    <span>✅</span><span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-2 mb-6">
                    <span>⚠️</span><span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm mb-6">
                    <div class="font-bold flex items-center gap-1.5 mb-1.5">
                        <span>⚠️</span><span>Mohon periksa input formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Timbang Multi-Item --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center text-lg">⚖️</div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">Input Timbangan Baru</h2>
                        <p class="text-xs text-slate-500">Catat setoran sampah warga ke buku tabungan digital</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.timbang.store') }}" id="formTimbang">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Nasabah <span class="text-rose-500">*</span></label>
                            <select name="id_user" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="">-- Pilih Nasabah Terdaftar --</option>
                                @foreach ($nasabahList as $n)
                                    <option value="{{ $n->id_user }}">{{ $n->nama_lengkap }} (Saldo: Rp {{ number_format($n->saldo, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Metode Setoran</label>
                            <select name="metode_setor" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="antar_sendiri">Antar Sendiri ke Depo</option>
                                <option value="jemput_bentor">Jemput Armada Bentor</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Setoran</label>
                            <input type="date" name="tanggal_setor" value="{{ date('Y-m-d') }}" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>

                    {{-- Item Sampah --}}
                    <div id="itemContainer" class="space-y-3 mb-4">
                        <div class="item-row grid grid-cols-12 gap-2 items-end">
                            <div class="col-span-5">
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Jenis Sampah</label>
                                <select name="items[0][id_sampah]" required onchange="updateHarga(this)"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none item-select">
                                    <option value="">-- Pilih Jenis --</option>
                                    @foreach ($sampahList as $s)
                                        <option value="{{ $s->id_sampah }}" data-harga="{{ $s->harga_beli_nasabah }}">
                                            {{ $s->nama_sampah }} (Rp {{ number_format($s->harga_beli_nasabah, 0, ',', '.') }}/{{ $s->satuan }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Berat (Kg)</label>
                                <input type="number" step="0.1" min="0.1" name="items[0][berat]" required
                                    oninput="calcRow(this)"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500 item-berat">
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Subtotal</label>
                                <div class="px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-700 item-subtotal">Rp 0</div>
                            </div>
                            <div class="col-span-2 flex gap-1">
                                <button type="button" onclick="addItem()" class="flex-1 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 rounded-xl text-xs font-bold transition">+ Item</button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200 mb-4">
                        <span class="text-sm font-bold text-slate-700">Total Nilai Setoran:</span>
                        <span class="text-xl font-extrabold text-emerald-700" id="grandTotal">Rp 0</span>
                    </div>

                    <button type="submit" id="btnSubmitTimbang" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.99] text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                        <span id="btnIcon">⚖️</span>
                        <span id="btnText">Simpan & Cetak Nota Timbangan</span>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('formTimbang').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmitTimbang');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            document.getElementById('btnIcon').textContent = '⏳';
            document.getElementById('btnText').textContent = 'Menyimpan & Membuka Nota...';
        });
        let itemCount = 1;

        const sampahOptions = `@foreach ($sampahList as $s)<option value="{{ $s->id_sampah }}" data-harga="{{ $s->harga_beli_nasabah }}">{{ $s->nama_sampah }} (Rp {{ number_format($s->harga_beli_nasabah,0,',','.') }}/{{ $s->satuan }})</option>@endforeach`;

        function addItem() {
            const idx = itemCount++;
            const row = document.createElement('div');
            row.className = 'item-row grid grid-cols-12 gap-2 items-end';
            row.innerHTML = `
                <div class="col-span-5">
                    <select name="items[${idx}][id_sampah]" required onchange="updateHarga(this)"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none item-select">
                        <option value="">-- Pilih Jenis --</option>${sampahOptions}
                    </select>
                </div>
                <div class="col-span-2">
                    <input type="number" step="0.1" min="0.1" name="items[${idx}][berat]" required
                        oninput="calcRow(this)"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500 item-berat" placeholder="0.0">
                </div>
                <div class="col-span-3">
                    <div class="px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-700 item-subtotal">Rp 0</div>
                </div>
                <div class="col-span-2">
                    <button type="button" onclick="this.closest('.item-row').remove(); calcGrand()" class="w-full py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-xl text-xs font-bold transition">Hapus</button>
                </div>`;
            document.getElementById('itemContainer').appendChild(row);
        }

        function updateHarga(sel) { calcRow(sel.closest('.item-row').querySelector('.item-berat')); }

        function calcRow(beratInput) {
            const row = beratInput.closest('.item-row');
            const sel = row.querySelector('.item-select');
            const harga = parseFloat(sel?.selectedOptions[0]?.dataset.harga || 0);
            const berat = parseFloat(beratInput.value || 0);
            const sub = harga * berat;
            row.querySelector('.item-subtotal').textContent = 'Rp ' + sub.toLocaleString('id-ID');
            calcGrand();
        }

        function calcGrand() {
            let total = 0;
            document.querySelectorAll('.item-subtotal').forEach(el => {
                total += parseFloat(el.textContent.replace(/[^0-9]/g, '')) || 0;
            });
            document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>
