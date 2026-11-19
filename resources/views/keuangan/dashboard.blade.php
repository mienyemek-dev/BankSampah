<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Manajemen Keuangan & Kas - Bank Sampah Bumi Sai Wawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    {{-- ============================================================ --}}
    {{-- SIDEBAR BENDAHARA RESMI DENGAN TEMA HIJAU ECO SEGAR         --}}
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
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-md shadow-emerald-950/40 border border-emerald-400/40 transition">
                <span class="text-base">📊</span> 
                <span>Dashboard Kas</span>
            </a>

            <a href="{{ route('keuangan.penarikan') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <div class="flex items-center gap-3">
                    <span class="text-base group-hover:scale-110 transition">📲</span>
                    <span>Pencairan E-Wallet</span>
                </div>
                @if($antreanPencairan > 0)
                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-amber-400 text-emerald-950 animate-pulse shadow-sm">
                        {{ $antreanPencairan }}
                    </span>
                @else
                    <span class="text-[10px] text-emerald-400">0</span>
                @endif
            </a>

            <a href="{{ route('keuangan.buku_kas') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <span class="text-base group-hover:scale-110 transition">📒</span>
                <span>Buku Kas & Mutasi</span>
            </a>
        </nav>

        {{-- Footer Sidebar: Profil & Logout --}}
        <div class="p-4 border-t border-emerald-800/70 bg-emerald-950/70">
            <div class="flex items-center justify-between mb-3">
                <a href="{{ route('home') }}" target="_blank" class="text-[11px] text-emerald-200/80 hover:text-white transition flex items-center gap-1 font-semibold">
                    <span>🌐 Buka Halaman Depan &rarr;</span>
                </a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full py-2.5 px-3 bg-emerald-900/90 hover:bg-rose-600 text-emerald-100 hover:text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 border border-emerald-700/60 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ============================================================ --}}
    {{-- AREA KONTEN UTAMA                                            --}}
    {{-- ============================================================ --}}
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        {{-- Top Bar Header --}}
        <header class="bg-white border-b border-slate-200/90 px-6 sm:px-8 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 sticky top-0 z-20 backdrop-blur-md bg-white/95">
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight" id="greeting-text">
                    Manajemen Finansial & Kas
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Otorisasi pencairan saldo e-wallet nasabah & rekapitulasi buku kas pembukuan
                </p>
            </div>

            {{-- Jam & Tanggal Interaktif Real-time --}}
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-800" id="live-time">--:--:-- WIB</p>
                    <p class="text-[11px] text-slate-400 font-medium" id="live-date">Memuat tanggal...</p>
                </div>
                <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->nama_lengkap }}</p>
                        <p class="text-[10px] text-slate-400">Bendahara / Admin Kas</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Konten Utama Dashboard --}}
        <main class="p-6 sm:p-8 flex-1 space-y-6 max-w-7xl w-full mx-auto">
            
            {{-- Flash Alert --}}
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-center gap-3 shadow-sm">
                    <span class="text-lg">✅</span>
                    <span class="font-medium text-xs sm:text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-sm flex items-center gap-3 shadow-sm">
                    <span class="text-lg">ℹ️</span>
                    <span class="font-medium text-xs sm:text-sm">{{ session('info') }}</span>
                </div>
            @endif

            {{-- ======================================================== --}}
            {{-- HERO OPERASIONAL KEUANGAN HIJAU ECO                      --}}
            {{-- ======================================================== --}}
            <div class="rounded-3xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 text-white p-6 sm:p-7 shadow-xl shadow-emerald-900/15 border border-emerald-600/40 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                {{-- Aksen Dekorasi Halus --}}
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute top-0 right-1/4 w-32 h-32 bg-emerald-400/10 rounded-full blur-xl pointer-events-none"></div>

                <div class="relative z-10 text-center md:text-left flex-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/70 border border-emerald-400/40 text-[11px] font-bold text-emerald-200 mb-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-ping"></span>
                        <span>Otorisasi Kas & Dompet Digital</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white drop-shadow-sm">
                        Kelola Arus Kas & Pencairan E-Wallet 💰
                    </h2>
                    <p class="text-xs sm:text-sm text-emerald-100/90 mt-1 max-w-xl leading-relaxed">
                        Validasi pengajuan pencairan saldo tabungan sampah nasabah ke DANA, GoPay, OVO, ShopeePay & LinkAja secara tepat dan bebas biaya admin.
                    </p>

                    {{-- Tombol Aksi Cepat --}}
                    <div class="mt-5 flex flex-wrap items-center justify-center md:justify-start gap-2.5">
                        <a href="{{ route('keuangan.penarikan') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-emerald-50 text-emerald-900 text-xs font-black shadow-lg shadow-emerald-950/20 hover:scale-105 transition duration-150">
                            <span>📲 Otorisasi Pencairan</span>
                            @if($antreanPencairan > 0)
                                <span class="bg-amber-500 text-slate-950 text-[10px] font-black px-1.5 py-0.2 rounded-full">
                                    {{ $antreanPencairan }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('keuangan.buku_kas') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-900/70 hover:bg-emerald-900 text-emerald-100 hover:text-white text-xs font-bold border border-emerald-500/40 shadow-sm transition">
                            <span>📒 Buku Kas & Jurnal</span>
                        </a>
                    </div>
                </div>

                {{-- Maskot Si Wawai Menyapa (Miniatur Halus) --}}
                <div class="relative z-10 flex-shrink-0 hidden lg:flex items-center justify-center">
                    <div class="p-3.5 rounded-2xl bg-emerald-900/70 border border-emerald-400/40 backdrop-blur-md flex items-center gap-3 max-w-xs group cursor-pointer shadow-md"
                         onclick="reactSiWawai()" title="Klik Si Wawai!">
                        <img src="{{ asset('images/mascot/siwawai-point.webp') }}" 
                             alt="Si Wawai" 
                             class="w-14 h-14 object-contain filter drop-shadow group-hover:scale-110 transition duration-300">
                        <div>
                            <span class="text-[10px] font-black uppercase text-emerald-300 block tracking-wider">Tips Finansial</span>
                            <p class="text-[11px] text-emerald-100 leading-snug mt-0.5">
                                Pastikan nomor e-wallet & nama pemilik cocok sebelum konfirmasi transfer ya!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- 4 KARTU STATISTIK FINANSIAL (BENTO CLEAN DESIGN)         --}}
            {{-- ======================================================== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                {{-- 1. Simpanan Nasabah --}}
                <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-500 hover:-translate-y-1 transition duration-200 block group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Simpanan Nasabah</span>
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                            🏦
                        </div>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">
                        Rp {{ number_format($totalSimpananNasabah, 0, ',', '.') }}
                    </h3>
                    <div class="mt-3 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-500">Saldo aktif di sistem</span>
                        <span class="text-emerald-700 font-bold">Dana Tersimpan</span>
                    </div>
                </div>

                {{-- 2. Antrean Pencairan --}}
                <a href="{{ route('keuangan.penarikan') }}" 
                   class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-500 hover:-translate-y-1 transition duration-200 block group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Antrean E-Wallet</span>
                        <div class="w-9 h-9 rounded-xl {{ $antreanPencairan > 0 ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                            📲
                        </div>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold {{ $antreanPencairan > 0 ? 'text-amber-600' : 'text-slate-800' }} mt-2 tracking-tight">
                        {{ $antreanPencairan }} <span class="text-xs font-semibold text-slate-500">Pengajuan</span>
                    </h3>
                    <div class="mt-3 flex items-center justify-between text-xs">
                        <span class="text-[11px] {{ $antreanPencairan > 0 ? 'text-amber-700 font-bold' : 'text-slate-400' }}">
                            {{ $antreanPencairan > 0 ? 'Menunggu Transfer Admin' : 'Semua Selesai Dicairkan' }}
                        </span>
                        <span class="text-amber-600 font-bold group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </div>
                </a>

                {{-- 3. Total Pencairan Berhasil --}}
                <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-500 hover:-translate-y-1 transition duration-200 block group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pencairan Berhasil</span>
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                            💳
                        </div>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-2 tracking-tight">
                        Rp {{ number_format($totalPencairanSelesai, 0, ',', '.') }}
                    </h3>
                    <div class="mt-3 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-500">Total keluar ke nasabah</span>
                        <span class="text-emerald-700 font-bold">Terbayar</span>
                    </div>
                </div>

                {{-- 4. Pendapatan Pengepul --}}
                <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-500 hover:-translate-y-1 transition duration-200 block group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penjualan Pabrik</span>
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition">
                            🏭
                        </div>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-blue-700 mt-2 tracking-tight">
                        Rp {{ number_format($totalPendapatanPengepul, 0, ',', '.') }}
                    </h3>
                    <div class="mt-3 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-500">Kas masuk daur ulang</span>
                        <span class="text-blue-700 font-bold">Kas Pengepul</span>
                    </div>
                </div>

            </div>

            {{-- ======================================================== --}}
            {{-- DUA PANEL BENTO: ANTREAN E-WALLET & JURNAL MUTASI KAS     --}}
            {{-- ======================================================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- KOLOM KIRI: ANTREAN PENCAIRAN E-WALLET (LEBAR 7/12) --}}
                <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 pb-4 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-extrabold text-base text-slate-900">Antrean Pencairan E-Wallet</h3>
                                @if($antreanPencairan > 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800">
                                        {{ $antreanPencairan }} Menunggu
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Otorisasi transfer saldo tabungan ke dompet digital nasabah</p>
                        </div>
                        <a href="{{ route('keuangan.penarikan') }}" 
                           class="text-xs font-bold text-emerald-700 hover:underline">
                            Lihat Semua Riwayat &rarr;
                        </a>
                    </div>

                    {{-- Search Filter Instan --}}
                    <div class="mb-4">
                        <div class="relative">
                            <input type="text" 
                                   id="search-penarikan" 
                                   onkeyup="filterPenarikanTable()"
                                   placeholder="🔍 Cari nama nasabah / no. e-wallet..." 
                                   class="w-full px-3.5 py-2 pl-9 rounded-xl border border-slate-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-slate-50/50">
                            <span class="absolute left-3 top-2.5 text-xs text-slate-400">🔍</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="table-penarikan">
                            <thead>
                                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                                    <th class="pb-2">Nasabah</th>
                                    <th class="pb-2">Tujuan E-Wallet</th>
                                    <th class="pb-2 text-right">Nominal</th>
                                    <th class="pb-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse ($permohonanTerbaru as $pen)
                                    @php
                                        $wName = strtolower($pen->nama_bank);
                                        $wColor = 'bg-slate-100 text-slate-800 border-slate-200';
                                        if (str_contains($wName, 'dana')) {
                                            $wColor = 'bg-blue-50 text-blue-700 border-blue-200';
                                        } elseif (str_contains($wName, 'gopay')) {
                                            $wColor = 'bg-sky-50 text-sky-700 border-sky-200';
                                        } elseif (str_contains($wName, 'ovo')) {
                                            $wColor = 'bg-purple-50 text-purple-700 border-purple-200';
                                        } elseif (str_contains($wName, 'shopee')) {
                                            $wColor = 'bg-orange-50 text-orange-700 border-orange-200';
                                        } elseif (str_contains($wName, 'linkaja')) {
                                            $wColor = 'bg-rose-50 text-rose-700 border-rose-200';
                                        }
                                    @endphp
                                    <tr class="penarikan-row hover:bg-slate-50/80 transition">
                                        <td class="py-3">
                                            <p class="font-bold text-slate-800 nasabah-name">{{ $pen->nasabah->nama_lengkap ?? 'Nasabah' }}</p>
                                            <p class="text-[10px] text-slate-400 font-mono">{{ $pen->kode_penarikan }} &bull; {{ $pen->tanggal_pengajuan ? \Carbon\Carbon::parse($pen->tanggal_pengajuan)->format('d M H:i') : '-' }}</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg border text-[11px] font-bold {{ $wColor }} mb-1">
                                                <span>📲</span> {{ strtoupper($pen->nama_bank) }}
                                            </div>
                                            <p class="font-mono text-[11px] text-slate-700 font-semibold wallet-acc">{{ $pen->nomor_rekening }}</p>
                                            <p class="text-[10px] text-slate-400">an. {{ $pen->atas_nama }}</p>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="font-extrabold text-emerald-700 text-xs sm:text-sm">
                                                Rp {{ number_format($pen->nominal_penarikan, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                {{-- Form Setujui & Cairkan --}}
                                                <form method="POST" action="{{ route('keuangan.penarikan.proses', $pen->id_penarikan) }}" onsubmit="return confirm('Konfirmasi pencairan dana Rp {{ number_format($pen->nominal_penarikan, 0, ',', '.') }} ke {{ $pen->nama_bank }} ({{ $pen->nomor_rekening }}) an. {{ $pen->atas_nama }}?')">
                                                    @csrf
                                                    <input type="hidden" name="action" value="setujui">
                                                    <button type="submit" 
                                                            class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[11px] font-bold shadow-sm transition inline-flex items-center gap-1"
                                                            title="Setujui dan catat transfer selesai">
                                                        <span>✓</span> Cairkan
                                                    </button>
                                                </form>

                                                {{-- Form Tolak --}}
                                                <form method="POST" action="{{ route('keuangan.penarikan.proses', $pen->id_penarikan) }}" onsubmit="return confirm('Tolak permohonan ini dan kembalikan saldo ke nasabah?')">
                                                    @csrf
                                                    <input type="hidden" name="action" value="tolak">
                                                    <button type="submit" 
                                                            class="p-1.5 bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 rounded-lg text-xs font-bold transition"
                                                            title="Tolak permohonan">
                                                        ✕
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400">
                                            <div class="text-3xl mb-2">🎉</div>
                                            <p class="font-bold text-slate-700 text-xs">Semua Pengajuan Telah Ditransfer!</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada antrean pencairan e-wallet yang menunggu saat ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- KOLOM KANAN: JURNAL MUTASI KAS TERBARU (LEBAR 5/12) --}}
                <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                        <div>
                            <h3 class="font-extrabold text-base text-slate-900">Mutasi Kas Terbaru</h3>
                            <p class="text-xs text-slate-500">Jurnal debet & kredit sistem real-time</p>
                        </div>
                        <a href="{{ route('keuangan.buku_kas') }}" 
                           class="text-xs font-bold text-emerald-700 hover:underline">
                            Buka Buku Kas &rarr;
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs">
                        @forelse ($mutasiTerbaru as $m)
                            <div class="py-3 flex items-start justify-between gap-3 hover:bg-slate-50/60 px-1 rounded-xl transition">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full {{ $m->jenis_mutasi === 'kredit' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        <p class="font-bold text-slate-800 truncate">{{ $m->user->nama_lengkap ?? 'Sistem' }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
                                        {{ $m->keterangan }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-mono mt-0.5">
                                        {{ $m->created_at ? $m->created_at->format('d M Y H:i') : '-' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="font-extrabold text-xs {{ $m->jenis_mutasi === 'kredit' ? 'text-emerald-700' : 'text-rose-600' }}">
                                        {{ $m->jenis_mutasi === 'kredit' ? '+' : '-' }} Rp {{ number_format($m->jumlah, 0, ',', '.') }}
                                    </span>
                                    <span class="block text-[10px] uppercase font-bold text-slate-400">
                                        {{ $m->kategori_transaksi }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-400 py-8 text-center text-xs">
                                Belum ada riwayat mutasi kas terbaru.
                            </p>
                        @endforelse
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <a href="{{ route('keuangan.buku_kas') }}" 
                           class="w-full py-2 px-3 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold text-center block transition">
                            Lihat Pembukuan Kas Selengkapnya &rarr;
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>

    {{-- Script Jam Real-Time & Filter Interaktif --}}
    <script>
        // 1. Live Real-time Clock & Greeting
        function updateLiveTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
            const dateString = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

            const timeEl = document.getElementById('live-time');
            const dateEl = document.getElementById('live-date');
            if (timeEl) timeEl.innerText = timeString;
            if (dateEl) dateEl.innerText = dateString;

            // Sapaan dinamis
            const hour = now.getHours();
            let greeting = 'Selamat Pagi';
            if (hour >= 11 && hour < 15) greeting = 'Selamat Siang';
            else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';
            else if (hour >= 18 || hour < 5) greeting = 'Selamat Malam';

            const greetEl = document.getElementById('greeting-text');
            if (greetEl) greetEl.innerText = `${greeting}, {{ explode(' ', Auth::user()->nama_lengkap)[0] }}! 💰`;
        }

        setInterval(updateLiveTime, 1000);
        updateLiveTime();

        // 2. Client-side Instant Search Filter untuk Tabel Penarikan
        function filterPenarikanTable() {
            const input = document.getElementById('search-penarikan');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.penarikan-row');

            rows.forEach(row => {
                const name = row.querySelector('.nasabah-name')?.innerText.toLowerCase() || '';
                const acc = row.querySelector('.wallet-acc')?.innerText.toLowerCase() || '';
                if (name.includes(filter) || acc.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

    {{-- Maskot Interaktif Si Wawai (Di Kanan Bawah agar tidak menutupi Sidebar) --}}
    @include('components.mascot-siwawai', ['position' => 'right'])
</body>
</html>
