<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Nasabah - Bank Sampah Bumi Sai Wawai</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Plus_Jakarta_Sans'] text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <nav class="relative text-white shadow-xl sticky top-0 z-50 overflow-hidden bg-cover bg-center border-b border-emerald-500/30"
         style="background-image: url('{{ asset('images/navbar-bg.webp') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/70 via-black/20 to-black/40 pointer-events-none"></div>
        <div class="relative z-10 max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo-circle.png') }}" alt="Logo Bank Sampah" class="w-10 h-10 rounded-full shadow border border-emerald-400/40 object-cover group-hover:scale-105 transition">
                <div>
                    <h1 class="font-extrabold text-sm sm:text-base leading-tight">Bank Sampah Bumi Sai Wawai</h1>
                    <span class="text-[11px] text-emerald-200 font-medium">Panel Nasabah & Tabungan</span>
                </div>
            </a>

            <!-- Sisi Kanan: Identitas Nasabah & Menu Aksi -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Info Pengguna (Avatar + Nama) -->
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 border border-emerald-400/40 flex items-center justify-center text-xs font-bold text-white shadow-inner flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <span class="block text-[10px] text-emerald-300 font-medium leading-none">Halo, Nasabah</span>
                        <p class="text-xs font-bold text-white leading-tight mt-1 truncate max-w-[130px] md:max-w-[170px]" title="{{ Auth::user()->nama_lengkap }}">
                            {{ Auth::user()->nama_lengkap }}
                        </p>
                    </div>
                </div>

                <!-- Separator Tipis -->
                <div class="h-6 w-px bg-emerald-700/80 hidden sm:block"></div>

                <!-- Tombol Aksi (Profil & Keluar) -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('profil') }}" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-700/80 hover:bg-emerald-600 text-white text-xs font-semibold border border-emerald-600/60 shadow-sm transition"
                        title="Pengaturan Profil & Sandi">
                        <svg class="w-3.5 h-3.5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="hidden md:inline">Profil Saya</span>
                        <span class="md:hidden">Profil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-900/60 hover:bg-rose-600 text-emerald-100 hover:text-white text-xs font-semibold border border-emerald-700/60 shadow-sm transition"
                            title="Keluar dari akun">
                            <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
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

        <!-- Banner Selamat Datang Bersama Maskot Si Wawai -->
        <div class="mb-8 rounded-3xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 text-white p-6 sm:p-7 shadow-xl shadow-emerald-900/10 relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-6 border border-emerald-600/40">
            <!-- Background Ornaments -->
            <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute top-0 right-1/4 w-32 h-32 bg-emerald-400/10 rounded-full blur-xl pointer-events-none"></div>
            
            <div class="relative z-10 text-center sm:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-900/60 border border-emerald-400/40 text-[11px] font-bold text-emerald-200 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Selamat Datang Kembali!</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Halo, {{ Auth::user()->nama_lengkap }}! 👋
                </h2>
                <p class="text-xs sm:text-sm text-emerald-100/90 mt-2 max-w-xl leading-relaxed">
                    Siap pilah sampah hari ini? Bersama <strong class="text-white underline decoration-emerald-300">Si Wawai</strong>, ubah sampah rumah tanggamu jadi saldo tabungan berkah dan kelestarian Banjar Rejo.
                </p>
                <div class="mt-4 flex flex-wrap items-center justify-center sm:justify-start gap-2.5 text-xs">
                    <span class="px-3 py-1 rounded-lg bg-emerald-900/40 border border-emerald-500/30 text-emerald-100 font-medium">
                        🌱 Dusun: {{ Auth::user()->dusun ?? 'Banjar Rejo' }}
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-emerald-900/40 border border-emerald-500/30 text-emerald-100 font-medium">
                        📦 RT/RW: {{ Auth::user()->rt ?? '01' }}/{{ Auth::user()->rw ?? '01' }}
                    </span>
                </div>
            </div>

            <!-- Maskot Si Wawai Menyambut -->
            <div class="relative z-10 flex-shrink-0 flex items-center justify-center">
                <div class="relative group cursor-pointer" onclick="reactSiWawai()" title="Klik untuk sapa Si Wawai!">
                    <div class="absolute inset-0 rounded-full bg-emerald-400/30 blur-xl group-hover:bg-emerald-400/50 transition"></div>
                    <img src="{{ asset('images/mascot/siwawai-welcome.webp') }}" 
                         alt="Si Wawai Menyapa" 
                         class="w-28 h-28 sm:w-32 sm:h-32 object-contain filter drop-shadow-2xl transform group-hover:scale-105 group-hover:rotate-2 transition duration-300 animate-float">
                    <div class="absolute -bottom-2 bg-emerald-950/85 border border-emerald-400/40 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-emerald-200 whitespace-nowrap shadow-md left-1/2 -translate-x-1/2">
                        Si Wawai 🌿
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Saldo Card -->
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg shadow-emerald-700/20 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-xs font-medium text-emerald-100 uppercase tracking-wider">Total Saldo Tabungan</p>
                    <h3 class="text-3xl font-extrabold mt-2 tracking-tight">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</h3>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('nasabah.tarik_saldo') }}" class="px-3.5 py-1.5 bg-white text-emerald-800 rounded-lg text-xs font-bold shadow hover:bg-emerald-50 transition">
                            Tarik Saldo
                        </a>
                        <a href="{{ route('nasabah.katalog') }}" class="px-3.5 py-1.5 bg-emerald-700/80 text-white rounded-lg text-xs font-bold hover:bg-emerald-800 transition">
                            Tukar Pupuk
                        </a>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 text-emerald-500/20 text-8xl font-black select-none">
                    Rp
                </div>
            </div>

            <!-- Total Berat Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm relative overflow-hidden">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Sampah Disetor</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-2 tracking-tight">{{ number_format(Auth::user()->total_berat_sampah, 1) }} <span class="text-lg font-semibold text-slate-500">Kg</span></h3>
                <div class="mt-4">
                    <a href="{{ route('nasabah.riwayat_tabungan') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                        Lihat Riwayat Penimbangan &rarr;
                    </a>
                </div>
            </div>

            <!-- Status Akun Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Keanggotaan</p>
                <div class="mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        ● Akun Aktif
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-3">ID Nasabah: #{{ Auth::user()->id_user }}</p>
                <p class="text-xs text-slate-500 mt-1">Wilayah: {{ Auth::user()->desa ?? 'Desa Banjar Rejo' }}, Batanghari</p>
            </div>
        </div>

        <!-- Quick Actions Navigation (Layanan Cepat Nasabah - Ukuran Besar & Menarik) -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wider mb-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        Menu Utama Nasabah
                    </div>
                    <h3 class="text-lg sm:text-xl font-extrabold text-slate-800">Layanan Cepat & Mandiri</h3>
                    <p class="text-xs sm:text-sm text-slate-500">Pilih layanan di bawah untuk penjemputan sampah, transaksi saldo, atau katalog pupuk.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                <!-- 1. Minta Jemput Bentor -->
                <a href="{{ route('nasabah.jemput_sampah') }}" 
                    class="bg-white p-6 sm:p-7 rounded-3xl border-2 border-slate-200/90 hover:border-emerald-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 block group relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-28 h-28 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-60"></div>
                    
                    <!-- Icon Visual Besar -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-lg shadow-emerald-600/30 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300 mb-5 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Icon Armada Bentor / Kendaraan Sampah -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8h4.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9h3m-3 3h3" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 mb-2">
                            Armada Bentor
                        </span>
                        <h4 class="text-base sm:text-lg font-extrabold text-slate-800 group-hover:text-emerald-700 transition">
                            Minta Jemput
                        </h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Panggil bentor bank sampah langsung ke rumah (Min. 5 Kg)
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-center gap-1.5 text-xs font-bold text-emerald-700 group-hover:gap-2.5 transition-all">
                            <span>Panggil Bentor</span>
                            <span class="text-sm">&rarr;</span>
                        </div>
                    </div>
                </a>

                <!-- 2. Tarik Saldo -->
                <a href="{{ route('nasabah.tarik_saldo') }}" 
                    class="bg-white p-6 sm:p-7 rounded-3xl border-2 border-slate-200/90 hover:border-teal-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 block group relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-28 h-28 bg-teal-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-60"></div>
                    
                    <!-- Icon Visual Besar -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-teal-600 via-teal-500 to-cyan-400 text-white flex items-center justify-center shadow-lg shadow-teal-500/30 group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-300 mb-5 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Icon Uang / Pencairan Saldo -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-teal-50 text-teal-700 border border-teal-200 mb-2">
                            Pencairan Uang
                        </span>
                        <h4 class="text-base sm:text-lg font-extrabold text-slate-800 group-hover:text-teal-700 transition">
                            Tarik Saldo
                        </h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Cairkan tabungan sampah langsung ke akun E-Wallet (DANA, GoPay, OVO, ShopeePay)
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-center gap-1.5 text-xs font-bold text-teal-700 group-hover:gap-2.5 transition-all">
                            <span>Cairkan Saldo</span>
                            <span class="text-sm">&rarr;</span>
                        </div>
                    </div>
                </a>

                <!-- 3. Katalog Produk Olahan -->
                <a href="{{ route('nasabah.katalog') }}" 
                    class="bg-white p-6 sm:p-7 rounded-3xl border-2 border-slate-200/90 hover:border-lime-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 block group relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-28 h-28 bg-lime-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-60"></div>
                    
                    <!-- Icon Visual Besar -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-lime-600 via-emerald-500 to-green-400 text-white flex items-center justify-center shadow-lg shadow-lime-500/30 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300 mb-5 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Icon Produk Organik / Bibit Kompos -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-2.5 0-5 2-5 5a5 5 0 0010 0c0-3-2.5-5-5-5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 13v5" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-lime-50 text-lime-800 border border-lime-200 mb-2">
                            Hasil Daur Ulang
                        </span>
                        <h4 class="text-base sm:text-lg font-extrabold text-slate-800 group-hover:text-lime-700 transition">
                            Katalog Pupuk
                        </h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Beli pupuk kompos, POC cair, dan lilin jelantah
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-center gap-1.5 text-xs font-bold text-lime-700 group-hover:gap-2.5 transition-all">
                            <span>Belanja Produk</span>
                            <span class="text-sm">&rarr;</span>
                        </div>
                    </div>
                </a>

                <!-- 4. Riwayat Tabungan -->
                <a href="{{ route('nasabah.riwayat_tabungan') }}" 
                    class="bg-white p-6 sm:p-7 rounded-3xl border-2 border-slate-200/90 hover:border-indigo-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 block group relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-28 h-28 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-60"></div>
                    
                    <!-- Icon Visual Besar -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-indigo-600 via-blue-500 to-sky-400 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-300 mb-5 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Icon Buku Rekening Tabungan -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 10h2m-2 3h3m6-3h2m-2 3h2" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200 mb-2">
                            Buku Tabungan
                        </span>
                        <h4 class="text-base sm:text-lg font-extrabold text-slate-800 group-hover:text-indigo-700 transition">
                            Riwayat & Resi
                        </h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Cek mutasi kas debit/kredit dan cetak ulang nota timbangan
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-center gap-1.5 text-xs font-bold text-indigo-700 group-hover:gap-2.5 transition-all">
                            <span>Buka Riwayat</span>
                            <span class="text-sm">&rarr;</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Daftar Harga Sampah Live Preview -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Daftar Harga Beli Sampah Hari Ini</h3>
                    <p class="text-xs text-slate-500">Nilai rupiah yang Anda dapatkan per kilogram atau liter sampah yang disetor</p>
                </div>
                <a href="{{ route('nasabah.harga_sampah') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach ($daftarSampah->take(4) as $s)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-emerald-700 uppercase">{{ $s->kategori->nama_kategori ?? 'Sampah' }}</span>
                        <p class="font-bold text-xs text-slate-800 mt-0.5 line-clamp-1">{{ $s->nama_sampah }}</p>
                        <p class="text-sm font-extrabold text-emerald-700 mt-1">Rp {{ number_format($s->harga_beli_nasabah, 0, ',', '.') }} <span class="text-[10px] font-normal text-slate-500">/ {{ $s->satuan }}</span></p>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} Bank Sampah Bumi Sai Wawai &bull; Desa Banjar Rejo, Lampung Timur
    </footer>

    <!-- Floating WhatsApp Helpdesk -->
    <a href="https://wa.me/6285379324445?text=Halo%20Admin%20Bank%20Sampah%20Bumi%20Sai%20Wawai%2C%20saya%20nasabah%20atas%20nama%20{{ urlencode(Auth::user()->nama_lengkap) }}%20ingin%20bertanya..."
       target="_blank"
       class="fixed bottom-6 right-6 z-50 flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-full shadow-xl transition transform hover:scale-105 group"
       title="Hubungi Admin via WhatsApp">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
        <span class="text-xs font-bold">Bantuan WhatsApp</span>
    </a>

    {{-- Maskot Interaktif Si Wawai --}}
    @include('components.mascot-siwawai')
</body>
</html>
