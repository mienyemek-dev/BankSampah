<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencairan Saldo ke E-Wallet - Bank Sampah Bumi Sai Wawai</title>
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
    <style>
        .ewallet-radio:checked + label {
            border-color: #059669;
            background-color: #ecfdf5;
            box-shadow: 0 0 0 2px #10b981;
        }
        .ewallet-radio:checked + label .check-icon {
            display: flex;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex flex-col">

    {{-- ============================================================ --}}
    {{-- TOP NAVBAR RESMI (DENGAN BACKGROUND GRADIENT USER)          --}}
    {{-- ============================================================ --}}
    <header class="relative text-white shadow-xl sticky top-0 z-40 border-b border-emerald-500/30 overflow-hidden bg-cover bg-center"
            style="background-image: url('{{ asset('images/navbar-bg.webp') }}');">
        {{-- Overlay subtle gradient agar teks & tombol tetap kontras dan jernih dibaca --}}
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/70 via-black/20 to-black/40 pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('nasabah.dashboard') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-black/30 hover:bg-black/40 text-white font-semibold text-xs sm:text-sm transition-all duration-150 border border-white/20 shadow-sm backdrop-blur-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Dashboard</span>
                </a>

                <div class="hidden sm:block h-6 w-px bg-white/20"></div>

                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-8 h-8 rounded-full border border-emerald-400/50 object-cover shadow">
                    <div>
                        <h1 class="font-extrabold text-sm sm:text-base leading-tight drop-shadow-sm">Pencairan Saldo E-Wallet</h1>
                        <p class="text-[11px] text-emerald-200 font-medium drop-shadow-sm">Bank Sampah Bumi Sai Wawai &bull; Banjar Rejo</p>
                    </div>
                </div>
            </div>

            {{-- Kartu Saldo di Navbar --}}
            <div class="flex items-center gap-3 bg-black/40 px-4 py-2 rounded-2xl border border-white/20 backdrop-blur-md shadow-inner">
                <div class="w-8 h-8 rounded-xl bg-lime-400/25 flex items-center justify-center text-lime-300 text-lg">
                    💰
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-emerald-200 uppercase tracking-wider font-semibold">Saldo Tabungan Anda</p>
                    <p class="text-sm sm:text-base font-black text-white">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </header>

    {{-- ============================================================ --}}
    {{-- KONTEN UTAMA LEBIH BESAR & LEGA                             --}}
    {{-- ============================================================ --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 flex-1 w-full">

        {{-- Flash Alerts --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3 shadow-sm">
                <span class="text-xl">✅</span>
                <div>
                    <h4 class="font-bold">Pengajuan Berhasil Dikirim!</h4>
                    <p class="text-xs text-emerald-800 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm flex items-start gap-3 shadow-sm">
                <span class="text-xl">⚠️</span>
                <div>
                    <h4 class="font-bold">Perhatian</h4>
                    <p class="text-xs text-rose-800 mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- ======================================================== --}}
            {{-- KOLOM KIRI: FORM PENCAIRAN E-WALLET (LEBAR 5/12)         --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-200/60 relative">

                {{-- Header Form --}}
                <div class="mb-5 pb-5 border-b border-slate-100">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold mb-2">
                        <span>📲</span> Khusus Saldo E-Wallet
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Form Tarik Saldo</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                        Pencairan langsung ke dompet digital Anda (DANA, GoPay, OVO, ShopeePay, LinkAja). Cepat, praktis, dan tanpa repot rekening bank!
                    </p>
                </div>

                {{-- Tips Edukasi Si Wawai --}}
                <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50/60 border border-emerald-200/90 flex items-center gap-4 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-emerald-300/10 rounded-full pointer-events-none"></div>
                    <img src="{{ asset('images/mascot/siwawai-point.webp') }}" 
                         alt="Si Wawai Menunjuk" 
                         class="w-16 h-16 sm:w-20 sm:h-20 object-contain filter drop-shadow flex-shrink-0 group-hover:scale-110 transition duration-300">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-black text-emerald-900 uppercase tracking-wider">Tips Si Wawai</span>
                            <span class="text-[10px] bg-emerald-600 text-white font-extrabold px-2 py-0.5 rounded-full shadow-xs">Bebas Biaya Admin</span>
                        </div>
                        <p class="text-xs text-slate-700 leading-relaxed font-medium">
                            Pencairan langsung ke nomor HP yang terdaftar di akun E-Wallet. Cepat, aman, dan tanpa biaya potongan transfer! 🌿
                        </p>
                    </div>
                </div>

                @php
                    $saldoAktif = Auth::user()->saldo ?? 0;
                    $saldoMengendapMin = 10000;
                    $maksimalTarik = max(0, $saldoAktif - $saldoMengendapMin);
                @endphp

                <form method="POST" action="{{ route('nasabah.tarik_saldo.store') }}" class="space-y-6">
                    @csrf
                    {{-- Metode Pencairan dikunci ke ewallet --}}
                    <input type="hidden" name="metode_pencairan" value="ewallet">

                    {{-- 1. NOMINAL PENARIKAN --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="nominal_penarikan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nominal Penarikan (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full">
                                Maks. Tarik: Rp {{ number_format($maksimalTarik, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 font-bold text-base group-focus-within:text-emerald-600 transition">
                                Rp
                            </div>
                            <input type="number" id="nominal_penarikan" name="nominal_penarikan" step="1" min="20000" max="{{ $maksimalTarik }}" required
                                value="{{ old('nominal_penarikan') }}"
                                placeholder="Contoh: 25000"
                                class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-2 border-slate-200 text-base font-bold text-slate-800 placeholder-slate-300 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition">
                        </div>

                        {{-- Tombol Cepat Nominal --}}
                        <div class="mt-2.5 flex flex-wrap gap-2">
                            <button type="button" onclick="setNominal(20000)"
                                class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-emerald-800 text-xs font-bold transition">
                                Rp 20.000
                            </button>
                            <button type="button" onclick="setNominal(50000)"
                                class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-emerald-800 text-xs font-bold transition">
                                Rp 50.000
                            </button>
                            <button type="button" onclick="setNominal(100000)"
                                class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-emerald-800 text-xs font-bold transition">
                                Rp 100.000
                            </button>
                            @if ($maksimalTarik >= 20000)
                            <button type="button" onclick="setNominal({{ $maksimalTarik }})"
                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition ml-auto">
                                Tarik Semua (Rp {{ number_format($maksimalTarik, 0, ',', '.') }})
                            </button>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            *Minimal penarikan <strong>Rp 20.000</strong> &bull; Saldo mengendap wajib <strong>Rp 10.000</strong>.
                        </p>
                    </div>

                    {{-- 2. PILIHAN E-WALLET (INTERAKTIF DENGAN KARTU PILIHAN) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5">
                            Pilih Dompet Digital (E-Wallet) <span class="text-rose-500">*</span>
                        </label>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            {{-- DANA --}}
                            <div>
                                <input type="radio" id="wallet_dana" name="nama_bank" value="DANA"
                                    class="hidden ewallet-radio" {{ old('nama_bank', 'DANA') === 'DANA' ? 'checked' : '' }} required>
                                <label for="wallet_dana"
                                    class="relative flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition text-center select-none group">
                                    <img src="{{ asset('images/wallets/dana.svg') }}" alt="DANA" class="w-10 h-10 rounded-xl shadow-sm object-contain mb-1.5 group-hover:scale-105 transition-transform">
                                    <span class="text-xs font-extrabold text-slate-800 group-hover:text-emerald-700">DANA</span>
                                    <span class="text-[10px] text-slate-400">Instan</span>
                                    <div class="check-icon hidden absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-emerald-500 text-white items-center justify-center text-[10px]">✓</div>
                                </label>
                            </div>

                            {{-- GoPay --}}
                            <div>
                                <input type="radio" id="wallet_gopay" name="nama_bank" value="GoPay"
                                    class="hidden ewallet-radio" {{ old('nama_bank') === 'GoPay' ? 'checked' : '' }}>
                                <label for="wallet_gopay"
                                    class="relative flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition text-center select-none group">
                                    <img src="{{ asset('images/wallets/gopay.svg') }}" alt="GoPay" class="w-10 h-10 rounded-xl shadow-sm object-contain mb-1.5 group-hover:scale-105 transition-transform">
                                    <span class="text-xs font-extrabold text-slate-800 group-hover:text-emerald-700">GoPay</span>
                                    <span class="text-[10px] text-slate-400">Gojek</span>
                                    <div class="check-icon hidden absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-emerald-500 text-white items-center justify-center text-[10px]">✓</div>
                                </label>
                            </div>

                            {{-- OVO --}}
                            <div>
                                <input type="radio" id="wallet_ovo" name="nama_bank" value="OVO"
                                    class="hidden ewallet-radio" {{ old('nama_bank') === 'OVO' ? 'checked' : '' }}>
                                <label for="wallet_ovo"
                                    class="relative flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition text-center select-none group">
                                    <img src="{{ asset('images/wallets/ovo.svg') }}" alt="OVO" class="w-10 h-10 rounded-xl shadow-sm object-contain mb-1.5 group-hover:scale-105 transition-transform">
                                    <span class="text-xs font-extrabold text-slate-800 group-hover:text-emerald-700">OVO</span>
                                    <span class="text-[10px] text-slate-400">Grab</span>
                                    <div class="check-icon hidden absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-emerald-500 text-white items-center justify-center text-[10px]">✓</div>
                                </label>
                            </div>

                            {{-- ShopeePay --}}
                            <div>
                                <input type="radio" id="wallet_shopee" name="nama_bank" value="ShopeePay"
                                    class="hidden ewallet-radio" {{ old('nama_bank') === 'ShopeePay' ? 'checked' : '' }}>
                                <label for="wallet_shopee"
                                    class="relative flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition text-center select-none group">
                                    <img src="{{ asset('images/wallets/shopeepay.svg') }}" alt="ShopeePay" class="w-10 h-10 rounded-xl shadow-sm object-contain mb-1.5 group-hover:scale-105 transition-transform">
                                    <span class="text-xs font-extrabold text-slate-800 group-hover:text-emerald-700">ShopeePay</span>
                                    <span class="text-[10px] text-slate-400">Shopee</span>
                                    <div class="check-icon hidden absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-emerald-500 text-white items-center justify-center text-[10px]">✓</div>
                                </label>
                            </div>

                            {{-- LinkAja --}}
                            <div class="col-span-2 sm:col-span-1">
                                <input type="radio" id="wallet_linkaja" name="nama_bank" value="LinkAja"
                                    class="hidden ewallet-radio" {{ old('nama_bank') === 'LinkAja' ? 'checked' : '' }}>
                                <label for="wallet_linkaja"
                                    class="relative flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition text-center select-none group">
                                    <img src="{{ asset('images/wallets/linkaja.svg') }}" alt="LinkAja" class="w-10 h-10 rounded-xl shadow-sm object-contain mb-1.5 group-hover:scale-105 transition-transform">
                                    <span class="text-xs font-extrabold text-slate-800 group-hover:text-emerald-700">LinkAja</span>
                                    <span class="text-[10px] text-slate-400">BUMN</span>
                                    <div class="check-icon hidden absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-emerald-500 text-white items-center justify-center text-[10px]">✓</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- 3. NOMOR HP E-WALLET --}}
                    <div>
                        <label for="nomor_rekening" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nomor HP Akun E-Wallet <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="text" id="nomor_rekening" name="nomor_rekening" required
                                value="{{ old('nomor_rekening', Auth::user()->no_hp) }}"
                                placeholder="Contoh: 085379324445"
                                class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-slate-200 text-sm font-semibold text-slate-800 placeholder-slate-300 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Pastikan nomor aktif dan terdaftar pada aplikasi E-Wallet yang dipilih.</p>
                    </div>

                    {{-- 4. ATAS NAMA PEMILIK AKUN --}}
                    <div>
                        <label for="atas_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Pemilik Akun E-Wallet <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" id="atas_nama" name="atas_nama" required
                                value="{{ old('atas_nama', Auth::user()->nama_lengkap) }}"
                                placeholder="Nama lengkap sesuai aplikasi"
                                class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-slate-200 text-sm font-semibold text-slate-800 placeholder-slate-300 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition">
                        </div>
                    </div>

                    {{-- Rangkuman Info --}}
                    <div class="p-3.5 bg-emerald-50/70 rounded-2xl border border-emerald-100 flex items-center justify-between text-xs">
                        <span class="text-slate-600 font-medium flex items-center gap-1.5">
                            <span class="text-emerald-600">🛡️</span> Biaya Admin Transfer:
                        </span>
                        <span class="font-extrabold text-emerald-800 uppercase tracking-wider">Gratis (Rp 0)</span>
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit"
                        class="w-full py-4 px-6 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 active:scale-[0.99] text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-xl shadow-emerald-600/30 transition-all duration-150 flex items-center justify-center gap-2">
                        <span>⚡ Ajukan Pencairan ke E-Wallet Sekarang</span>
                    </button>
                </form>
            </div>

            {{-- ======================================================== --}}
            {{-- KOLOM KANAN: TABEL RIWAYAT PENGAJUAN (LEBAR 7/12)        --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-200/60">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6 pb-5 border-b border-slate-100">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Riwayat Pencairan Saldo</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau status transfer dana oleh Admin Keuangan Bank Sampah.</p>
                    </div>
                    <span class="self-start sm:self-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                        Total: {{ $riwayatPenarikan->total() }} Pengajuan
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[11px] font-bold border-b border-slate-100">
                                <th class="p-3.5 rounded-l-xl">Kode &amp; Waktu</th>
                                <th class="p-3.5">Tujuan E-Wallet</th>
                                <th class="p-3.5">Nominal</th>
                                <th class="p-3.5 rounded-r-xl">Status Pencairan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($riwayatPenarikan as $p)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-3.5">
                                        <p class="font-mono font-bold text-slate-800 text-xs sm:text-sm">{{ $p->kode_penarikan }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                            {{ $p->tanggal_pengajuan->format('d M Y, H:i') }} WIB
                                        </p>
                                    </td>
                                    <td class="p-3.5">
                                        <div class="flex items-center gap-2.5">
                                            @php
                                                $walletLogos = [
                                                    'DANA' => 'wallets/dana.svg',
                                                    'GOPAY' => 'wallets/gopay.svg',
                                                    'OVO' => 'wallets/ovo.svg',
                                                    'SHOPEEPAY' => 'wallets/shopeepay.svg',
                                                    'LINKAJA' => 'wallets/linkaja.svg',
                                                ];
                                                $key = strtoupper(str_replace([' ', '-', '_'], '', $p->nama_bank));
                                                $logoSrc = $walletLogos[$key] ?? null;
                                            @endphp
                                            @if ($logoSrc)
                                                <img src="{{ asset('images/' . $logoSrc) }}" alt="{{ $p->nama_bank }}" class="w-8 h-8 rounded-xl object-contain shadow-sm flex-shrink-0">
                                            @else
                                                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 text-xs font-black flex items-center justify-center flex-shrink-0">
                                                    {{ strtoupper(substr($p->nama_bank, 0, 1)) }}
                                                </span>
                                            @endif
                                            <div>
                                                <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $p->nama_bank }}</p>
                                                <p class="text-[11px] text-slate-500 font-mono">{{ $p->nomor_rekening }}</p>
                                                <p class="text-[10px] text-slate-400">an. {{ $p->atas_nama }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3.5 font-black text-emerald-700 text-sm sm:text-base whitespace-nowrap">
                                        Rp {{ number_format($p->nominal_penarikan, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3.5 whitespace-nowrap">
                                        @if ($p->status_penarikan === 'diajukan')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Transfer
                                            </span>
                                        @elseif ($p->status_penarikan === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <span>✅</span>
                                                Berhasil Ditransfer
                                            </span>
                                        @elseif ($p->status_penarikan === 'ditolak')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200">
                                                <span>❌</span>
                                                Ditolak (Saldo Kembali)
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center">
                                        <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-3">
                                            📭
                                        </div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Riwayat Penarikan</p>
                                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                            Isi form di samping untuk mulai mencairkan saldo tabungan sampah Anda ke akun E-Wallet.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($riwayatPenarikan->hasPages())
                <div class="mt-6 pt-4 border-t border-slate-100">
                    {{ $riwayatPenarikan->links() }}
                </div>
                @endif

                {{-- Bantuan / Pertanyaan --}}
                <div class="mt-8 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">💬</span>
                        <div class="text-left">
                            <p class="text-xs font-bold text-slate-700">Butuh Bantuan Transfer?</p>
                            <p class="text-[11px] text-slate-500">Hubungi Admin Keuangan melalui WhatsApp resmi.</p>
                        </div>
                    </div>
                    <a href="https://wa.me/6285379324445?text=Halo%20Admin%20Keuangan%20Bank%20Sampah%20Bumi%20Sai%20Wawai%2C%20saya%20ingin%20bertanya%20seputar%20pencairan%20saldo%20e-wallet..."
                       target="_blank"
                       class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm whitespace-nowrap">
                        Chat WhatsApp Admin
                    </a>
                </div>

            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 py-5 text-center text-xs text-slate-500 mt-12">
        &copy; {{ date('Y') }} Bank Sampah Bumi Sai Wawai &bull; Desa Banjar Rejo, Batanghari, Lampung Timur
    </footer>

    <script>
        function setNominal(amount) {
            const input = document.getElementById('nominal_penarikan');
            input.value = amount;
            input.focus();
        }
    </script>

    {{-- Maskot Interaktif Si Wawai --}}
    @include('components.mascot-siwawai')
</body>
</html>
