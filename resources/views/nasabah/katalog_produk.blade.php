<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Pupuk & Produk Olahan - Bank Sampah Bumi Sai Wawai</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Plus_Jakarta_Sans'] text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <nav class="relative text-white shadow-xl overflow-hidden bg-cover bg-center border-b border-emerald-500/30"
         style="background-image: url('{{ asset('images/navbar-bg.webp') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/70 via-black/20 to-black/40 pointer-events-none"></div>
        <div class="relative z-10 max-w-6xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('nasabah.dashboard') }}" class="p-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-600 transition text-sm">
                    &larr; Kembali
                </a>
                <h1 class="font-bold text-base">Katalog Pupuk & Produk Daur Ulang</h1>
            </div>
            <div class="text-right">
                <p class="text-xs text-emerald-200">Saldo Anda:</p>
                <p class="text-sm font-extrabold text-white">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</p>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Banner Info -->
        <div class="mb-8 p-6 rounded-2xl bg-gradient-to-r from-emerald-800 to-teal-800 text-white shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-extrabold">Olahan Sampah Mandiri Bumi Sai Wawai</h2>
                <p class="text-xs text-emerald-200 mt-1 max-w-xl leading-relaxed">
                    Produk pupuk organik dan olahan minyak jelantah berkualitas tinggi hasil binaan Bank Sampah di Banjar Rejo. Anda dapat membelinya dengan <b>memotong saldo tabungan sampah</b> atau melalui <b>Virtual Payment Gateway</b>.
                </p>
            </div>
            <div class="text-4xl select-none">
                🌱
            </div>
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach ($produk as $p)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800">
                                {{ str_replace('_', ' ', $p->kategori) }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium">Stok: <b>{{ $p->stok }}</b> {{ $p->satuan }}</span>
                        </div>

                        <h3 class="text-base font-bold text-slate-800 mb-2">{{ $p->nama_produk }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                            {{ $p->deskripsi }}
                        </p>

                        <div class="pt-4 border-t border-slate-100">
                            <p class="text-xs text-slate-400">Harga Satuan:</p>
                            <p class="text-2xl font-extrabold text-emerald-700">Rp {{ number_format($p->harga_rupiah, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 border-t border-slate-100">
                        <button type="button" onclick="openBuyModal({{ $p->id_produk }}, '{{ $p->nama_produk }}', {{ $p->harga_rupiah }}, {{ $p->stok }})"
                            class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                            <span>🛒 Pesan / Beli Sekarang</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Daftar Pesanan Saya -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <h3 class="font-bold text-slate-800 text-base mb-1">Riwayat Pembelian & Pesanan Saya</h3>
            <p class="text-xs text-slate-500 mb-4">Daftar pesanan produk pupuk dan status pembayarannya.</p>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100">
                        <tr>
                            <th class="p-3">Kode Order</th>
                            <th class="p-3">Produk</th>
                            <th class="p-3">Metode Bayar</th>
                            <th class="p-3">Total Tagihan</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pesananSaya as $order)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3">
                                    <p class="font-bold text-slate-800">{{ $order->kode_order }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $order->tanggal_order->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="p-3">
                                    @foreach ($order->details as $d)
                                        <p class="font-semibold text-slate-700">{{ $d->produk->nama_produk ?? 'Produk' }} ({{ $d->jumlah }}x)</p>
                                    @endforeach
                                </td>
                                <td class="p-3">
                                    @if ($order->metode_bayar === 'saldo_sampah')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            🌿 Saldo Sampah (Cashless)
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">
                                            💳 Virtual Gateway
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 font-extrabold text-slate-800">
                                    Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}
                                </td>
                                <td class="p-3">
                                    @if ($order->status_order === 'dibayar' || $order->status_order === 'selesai')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            ✅ Lunas
                                        </span>
                                    @elseif ($order->status_order === 'menunggu_pembayaran')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                            ⏳ Menunggu Bayar
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 text-right">
                                    @if ($order->status_order === 'menunggu_pembayaran' && $order->pembayaran)
                                        <a href="{{ route('nasabah.payment_simulator', $order->pembayaran->id_pembayaran) }}"
                                            class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow transition">
                                            Bayar Sekarang &rarr;
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-400">
                                    Belum ada riwayat pembelian produk olahan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Beli Produk -->
    <div id="buyModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="font-bold text-base text-slate-800" id="modalNamaProduk">Beli Produk</h3>
                <button type="button" onclick="closeBuyModal()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>

            <form method="POST" action="{{ route('nasabah.beli_produk') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="id_produk" id="modalIdProduk">

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Jumlah Pesanan</label>
                    <input type="number" name="jumlah" id="modalJumlah" min="1" value="1" oninput="calculateTotal()" required
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Metode Pembayaran</label>
                    <select name="metode_bayar" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="saldo_sampah">🌿 Potong Saldo Tabungan (Saldo: Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }})</option>
                        <option value="virtual_gateway">💳 Virtual Payment Gateway (QRIS / Virtual Account)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Pengiriman / Pengambilan</label>
                    <textarea name="alamat_pengiriman" rows="2" required placeholder="Alamat rumah atau tulis 'Ambil di Depo'"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ Auth::user()->alamat_lengkap ?? 'Desa Banjar Rejo' }}</textarea>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl flex items-center justify-between border border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Total Tagihan:</span>
                    <span class="text-lg font-extrabold text-emerald-700" id="modalTotalTagihan">Rp 0</span>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="button" onclick="closeBuyModal()" class="w-1/3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPrice = 0;

        function openBuyModal(id, nama, harga, stok) {
            document.getElementById('modalIdProduk').value = id;
            document.getElementById('modalNamaProduk').innerText = 'Pesan: ' + nama;
            currentPrice = harga;
            document.getElementById('modalJumlah').max = stok;
            calculateTotal();
            document.getElementById('buyModal').classList.remove('hidden');
        }

        function closeBuyModal() {
            document.getElementById('buyModal').classList.add('hidden');
        }

        function calculateTotal() {
            const qty = parseInt(document.getElementById('modalJumlah').value) || 1;
            const total = qty * currentPrice;
            document.getElementById('modalTotalTagihan').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>

    {{-- Maskot Interaktif Si Wawai --}}
    @include('components.mascot-siwawai')
</body>
</html>

