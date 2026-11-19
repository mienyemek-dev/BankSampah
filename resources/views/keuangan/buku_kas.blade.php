<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Kas & Laporan Finansial - Panel Keuangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    {{-- ============================================================ --}}
    {{-- SIDEBAR BENDAHARA — TEMA HIJAU EMERALD KONSISTEN             --}}
    {{-- ============================================================ --}}
    <aside class="w-64 bg-gradient-to-b from-emerald-950 via-emerald-900 to-emerald-950 text-white flex flex-col flex-shrink-0 min-h-screen sticky top-0 border-r border-emerald-800/70 z-30 shadow-2xl">
        <div class="p-5 border-b border-emerald-800/70 bg-emerald-950/50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-10 h-10 rounded-full border border-emerald-400/50 object-cover shadow-md">
                <div>
                    <h2 class="font-extrabold text-sm leading-tight text-white drop-shadow-sm">Bank Sampah</h2>
                    <p class="text-xs text-emerald-300 font-semibold drop-shadow-sm">Bumi Sai Wawai</p>
                </div>
            </div>
            <div class="mt-3.5 px-3 py-1.5 rounded-xl bg-emerald-900/80 border border-emerald-700/60 flex items-center justify-between shadow-inner">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-emerald-100 uppercase tracking-wider">Bendahara & Kas</span>
                </div>
                <span class="text-[10px] text-emerald-300 font-extrabold">Aktif</span>
            </div>
        </div>

        <nav class="p-3.5 space-y-1.5 flex-1 overflow-y-auto">
            <a href="{{ route('keuangan.dashboard') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <span class="text-base group-hover:scale-110 transition">📊</span>
                <span>Dashboard Kas</span>
            </a>

            <a href="{{ route('keuangan.penarikan') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <span class="text-base group-hover:scale-110 transition">📲</span>
                <span>Pencairan E-Wallet</span>
            </a>

            <a href="{{ route('keuangan.buku_kas') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-md shadow-emerald-950/40 border border-emerald-400/40 transition">
                <span class="text-base">📒</span>
                <span>Mutasi & Buku Kas</span>
            </a>
        </nav>

        <div class="p-4 border-t border-emerald-800/70 bg-emerald-950/50">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-emerald-700 border border-emerald-500/50 flex items-center justify-center font-extrabold text-sm text-white shadow-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'B', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->nama_lengkap ?? 'Bendahara' }}</p>
                    <p class="text-[10px] text-emerald-400 truncate">{{ Auth::user()->email ?? 'keuangan@saiwawai.id' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm">
                    <span>🚪</span> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT                                                 --}}
    {{-- ============================================================ --}}
    <main class="flex-1 overflow-y-auto">
        {{-- Top Header --}}
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">📒 Buku Kas & Laporan Keuangan</h1>
                <p class="text-xs text-slate-500 mt-0.5">Rekap mutasi & arus kas Bank Sampah Bumi Sai Wawai</p>
            </div>
            <button onclick="window.print()"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm">
                🖨️ Cetak Laporan
            </button>
        </div>

        <div class="p-8 space-y-6">

            {{-- Ringkasan 3 Kartu Kas --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-lg">💰</div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kas Masuk</p>
                    </div>
                    <h3 class="text-2xl font-extrabold text-blue-700">Rp {{ number_format($totalPenjualanPabrik, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Penjualan ke pabrik daur ulang</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-100 flex items-center justify-center text-lg">💸</div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kas Keluar</p>
                    </div>
                    <h3 class="text-2xl font-extrabold text-rose-600">Rp {{ number_format($totalPencairan, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Pencairan dana ke nasabah</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    @php $laba = $totalPenjualanPabrik - $totalPencairan; @endphp
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl {{ $laba >= 0 ? 'bg-emerald-100' : 'bg-rose-100' }} flex items-center justify-center text-lg">
                            {{ $laba >= 0 ? '📈' : '📉' }}
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Laba Bersih</p>
                    </div>
                    <h3 class="text-2xl font-extrabold {{ $laba >= 0 ? 'text-emerald-700' : 'text-rose-600' }}">
                        Rp {{ number_format(abs($laba), 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] {{ $laba >= 0 ? 'text-emerald-600' : 'text-rose-500' }} mt-1 font-semibold">
                        {{ $laba >= 0 ? 'Surplus kas' : 'Defisit kas' }}
                    </p>
                </div>
            </div>

            {{-- Tabel Mutasi Kas --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Rincian Buku Kas — Mutasi Transaksi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Setiap pergerakan kas tercatat kronologis dalam buku besar</p>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchMutasi" placeholder="Cari keterangan..."
                            class="pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none w-44">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs" id="tableMutasi">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3">Waktu</th>
                                <th class="p-3">Pengguna</th>
                                <th class="p-3">Jenis</th>
                                <th class="p-3">Keterangan</th>
                                <th class="p-3 text-right">Nominal (Rp)</th>
                                <th class="p-3 text-right">Saldo Sesudah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($mutasiKas as $m)
                                <tr class="hover:bg-slate-50 transition mutasi-row">
                                    <td class="p-3 text-slate-500 font-mono whitespace-nowrap">
                                        {{ $m->created_at->format('d/m/Y') }}
                                        <p class="text-[10px] text-slate-400">{{ $m->created_at->format('H:i') }}</p>
                                    </td>
                                    <td class="p-3 font-semibold text-slate-700">
                                        {{ $m->user->nama_lengkap ?? 'Sistem' }}
                                        <span class="text-[10px] text-slate-400 block font-normal">{{ $m->user->role ?? '' }}</span>
                                    </td>
                                    <td class="p-3">
                                        @if ($m->jenis_mutasi === 'kredit')
                                            <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-emerald-100 text-emerald-800 flex items-center gap-1 w-fit">
                                                ↑ Kredit
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-rose-100 text-rose-800 flex items-center gap-1 w-fit">
                                                ↓ Debit
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-slate-700 max-w-xs">
                                        <p class="font-semibold">{{ $m->keterangan }}</p>
                                        @if ($m->referensi_kode)
                                            <span class="text-[10px] text-slate-400 font-mono">{{ $m->referensi_kode }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right font-bold {{ $m->jenis_mutasi === 'kredit' ? 'text-emerald-700' : 'text-rose-600' }} whitespace-nowrap">
                                        {{ $m->jenis_mutasi === 'kredit' ? '+' : '-' }} Rp {{ number_format($m->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3 text-right font-extrabold text-slate-800 whitespace-nowrap">
                                        Rp {{ number_format($m->saldo_sesudah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">
                                        <div class="text-3xl mb-2">📒</div>
                                        <p class="font-semibold">Belum ada mutasi kas tercatat</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $mutasiKas->links() }}
                </div>
            </div>

        </div>
    </main>

    <script>
        document.getElementById('searchMutasi')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.mutasi-row').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>

</body>
</html>
