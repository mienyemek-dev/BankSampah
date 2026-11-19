<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pencairan Saldo - Panel Keuangan</title>
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
        {{-- Brand Header --}}
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

        {{-- Nav Menu --}}
        <nav class="p-3.5 space-y-1.5 flex-1 overflow-y-auto">
            <a href="{{ route('keuangan.dashboard') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <span class="text-base group-hover:scale-110 transition">📊</span>
                <span>Dashboard Kas</span>
            </a>

            <a href="{{ route('keuangan.penarikan') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-md shadow-emerald-950/40 border border-emerald-400/40 transition">
                <span class="text-base">📲</span>
                <span>Pencairan E-Wallet</span>
            </a>

            <a href="{{ route('keuangan.buku_kas') }}"
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <div class="flex items-center gap-3">
                    <span class="text-base group-hover:scale-110 transition">📒</span>
                    <span>Mutasi & Buku Kas</span>
                </div>
            </a>
        </nav>

        {{-- User Info --}}
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
                <h1 class="text-base font-bold text-slate-800">📲 Permohonan Pencairan Dana Nasabah</h1>
                <p class="text-xs text-slate-500 mt-0.5">Otorisasi transfer dana e-wallet & rekening nasabah</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs bg-amber-100 text-amber-800 font-bold px-3 py-1.5 rounded-full border border-amber-200">
                    ⏳ Menunggu Otorisasi
                </span>
            </div>
        </div>

        <div class="p-8 space-y-6">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm flex items-center gap-2">
                    <span>ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            {{-- Stats Ringkas --}}
            <div class="grid grid-cols-3 gap-4">
                @php
                    $menunggu = $penarikanList->where('status_penarikan', 'diajukan')->count();
                    $selesai  = $penarikanList->where('status_penarikan', 'selesai')->count();
                    $ditolak  = $penarikanList->where('status_penarikan', 'ditolak')->count();
                @endphp
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-xl">⏳</div>
                    <div>
                        <p class="text-2xl font-extrabold text-amber-700">{{ $menunggu }}</p>
                        <p class="text-xs text-slate-500 font-semibold">Menunggu Proses</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-xl">✅</div>
                    <div>
                        <p class="text-2xl font-extrabold text-emerald-700">{{ $selesai }}</p>
                        <p class="text-xs text-slate-500 font-semibold">Selesai Dicairkan</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-xl">❌</div>
                    <div>
                        <p class="text-2xl font-extrabold text-rose-600">{{ $ditolak }}</p>
                        <p class="text-xs text-slate-500 font-semibold">Ditolak</p>
                    </div>
                </div>
            </div>

            {{-- Tabel Pencairan --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800">Daftar Semua Permohonan</h3>
                    <div class="relative">
                        <input type="text" id="searchPenarikan" placeholder="Cari nama / kode..."
                            class="pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none w-48">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs" id="tablePenarikan">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3">Kode & Tanggal</th>
                                <th class="p-3">Nama Nasabah</th>
                                <th class="p-3">Rekening / E-Wallet Tujuan</th>
                                <th class="p-3">Nominal</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($penarikanList as $pen)
                                <tr class="hover:bg-slate-50 transition pen-row">
                                    <td class="p-3">
                                        <span class="font-mono font-bold text-slate-800">{{ $pen->kode_penarikan }}</span>
                                        <p class="text-[11px] text-slate-400">{{ $pen->tanggal_pengajuan->format('d M Y, H:i') }}</p>
                                    </td>
                                    <td class="p-3 font-semibold text-slate-700">
                                        {{ $pen->nasabah->nama_lengkap ?? 'Nasabah' }}
                                        <p class="text-[11px] text-slate-400 font-normal">{{ $pen->nasabah->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="p-3">
                                        @php
                                            $bank = strtoupper($pen->nama_bank ?? '');
                                            $badgeColor = match(true) {
                                                str_contains($bank,'DANA')   => 'bg-blue-100 text-blue-800',
                                                str_contains($bank,'GOPAY')  => 'bg-sky-100 text-sky-800',
                                                str_contains($bank,'OVO')    => 'bg-purple-100 text-purple-800',
                                                str_contains($bank,'SHOPEEPAY') => 'bg-orange-100 text-orange-800',
                                                default                      => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold {{ $badgeColor }} mb-1">
                                            {{ $pen->nama_bank }}
                                        </span>
                                        <p class="text-[11px] text-slate-500 font-mono">{{ $pen->nomor_rekening }}</p>
                                        <p class="text-[10px] text-slate-400">a.n. {{ $pen->atas_nama }}</p>
                                    </td>
                                    <td class="p-3 font-extrabold text-emerald-700 text-sm">
                                        Rp {{ number_format($pen->nominal_penarikan, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3">
                                        @if ($pen->status_penarikan === 'diajukan')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                ⏳ Menunggu
                                            </span>
                                        @elseif ($pen->status_penarikan === 'selesai')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                ✅ Selesai
                                            </span>
                                        @elseif ($pen->status_penarikan === 'ditolak')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                                ❌ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right">
                                        @if ($pen->status_penarikan === 'diajukan')
                                            <div class="inline-flex gap-2">
                                                <form method="POST" action="{{ route('keuangan.penarikan.proses', $pen->id_penarikan) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="setujui">
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                                        ✔ Cairkan
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('keuangan.penarikan.proses', $pen->id_penarikan) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="tolak">
                                                    <button type="submit"
                                                        onclick="return confirm('Tolak permohonan ini dan kembalikan saldo ke nasabah?')"
                                                        class="px-2.5 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-800 rounded-lg text-xs font-bold transition">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">Sudah Diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">
                                        <div class="text-3xl mb-2">🎉</div>
                                        <p class="font-semibold">Tidak ada antrean pencairan dana</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $penarikanList->links() }}
                </div>
            </div>

        </div>
    </main>

    <script>
        // Instant search filter
        document.getElementById('searchPenarikan')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.pen-row').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>

</body>
</html>
