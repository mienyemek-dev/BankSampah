<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bank Sampah Bumi Sai Wawai – Desa Banjar Rejo, Kec. Batanghari, Kab. Lampung Timur. Kelola sampah rumah tangga, dapatkan tabungan, dan wujudkan lingkungan bersih bersama kami.">
    <title>Bank Sampah Bumi Sai Wawai – Sampah Jadi Berkah</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50:  '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 70%, #059669 100%);
        }
        .stat-card {
            background: rgba(6, 78, 59, 0.5);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.35);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            background: rgba(6, 78, 59, 0.7);
            border-color: rgba(110, 231, 183, 0.6);
            transform: translateY(-4px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.45);
        }
        .leaflet-container { font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .nav-link {
            transition: color 0.2s;
        }
        .nav-link:hover { color: #059669; }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

{{-- ============================================================ --}}
{{-- NAVBAR --}}
{{-- ============================================================ --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-circle.png') }}" alt="Logo Bank Sampah Bumi Sai Wawai" class="w-10 h-10 rounded-full shadow-sm border border-emerald-500/30 object-cover">
                <div class="hidden sm:block">
                    <p class="text-sm font-700 text-gray-900 leading-tight font-bold">Bank Sampah</p>
                    <p class="text-xs text-brand-600 font-semibold leading-tight">Bumi Sai Wawai</p>
                </div>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-7 text-sm font-medium text-gray-600">
                <a href="#layanan" class="nav-link">Layanan</a>
                <a href="#harga" class="nav-link">Harga Sampah</a>
                <a href="#produk" class="nav-link">Produk</a>
                <a href="#lokasi" class="nav-link">Lokasi</a>
                <a href="#berita" class="nav-link">Edukasi</a>
            </div>

            {{-- CTA Buttons --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard.redirect') }}"
                       class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-brand-700 hover:text-brand-800 text-sm font-semibold transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl transition shadow">
                        Daftar Gratis
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ============================================================ --}}
{{-- HERO SECTION DENGAN LATAR BELAKANG DESAIN BARU              --}}
{{-- ============================================================ --}}
<section class="min-h-screen flex items-center pt-16 relative overflow-hidden bg-cover bg-center sm:bg-right bg-no-repeat bg-emerald-950"
         style="background-image: url('{{ asset('images/hero-bg.webp') }}');">
    {{-- Overlay gradasi sinematis agar teks & angka statistik tetap jernih dan kontras tinggi --}}
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/90 via-emerald-950/65 to-emerald-900/20 pointer-events-none"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Hero Text --}}
            <div>
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur text-green-100 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
                    <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                    Desa Banjar Rejo, Kec. Batanghari, Lampung Timur
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                    Sampah Jadi
                    <span class="text-green-300">Berkah</span> 🌿
                </h1>
                <p class="text-green-100 text-lg leading-relaxed mb-8 max-w-lg">
                    Setor sampah rumah tanggamu, dapatkan tabungan nyata, dan ikut menjaga lingkungan bersama
                    <strong class="text-white">Bank Sampah Bumi Sai Wawai</strong>.
                </p>
                <div class="flex flex-wrap gap-4">
                    @guest
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-brand-700 font-bold rounded-2xl shadow-lg hover:shadow-xl hover:bg-green-50 transition text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 border-2 border-white/40 text-white font-semibold rounded-2xl hover:bg-white/10 transition text-sm">
                            Sudah Punya Akun? Masuk
                        </a>
                    @else
                        <a href="{{ route('dashboard.redirect') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-brand-700 font-bold rounded-2xl shadow-lg hover:shadow-xl hover:bg-green-50 transition text-sm">
                            Ke Dashboard →
                        </a>
                    @endguest
                    <a href="#layanan"
                       class="inline-flex items-center gap-2 px-6 py-3 border-2 border-white/30 text-white font-semibold rounded-2xl hover:bg-white/10 transition text-sm">
                        Lihat Layanan
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="stat-card rounded-2xl p-5 text-center">
                    <div class="text-3xl font-extrabold text-white mb-1">{{ number_format($totalNasabah) }}+</div>
                    <div class="text-green-200 text-sm font-medium">Nasabah Aktif</div>
                    <div class="mt-3 text-2xl">👥</div>
                </div>
                <div class="stat-card rounded-2xl p-5 text-center">
                    <div class="text-3xl font-extrabold text-white mb-1">{{ number_format($totalKgSampah, 0, ',', '.') }}<span class="text-lg">kg</span></div>
                    <div class="text-green-200 text-sm font-medium">Sampah Didaur Ulang</div>
                    <div class="mt-3 text-2xl">♻️</div>
                </div>
                <div class="stat-card rounded-2xl p-5 text-center">
                    <div class="text-3xl font-extrabold text-white mb-1">Rp{{ number_format($totalTabungan/1000, 0, ',', '.') }}rb</div>
                    <div class="text-green-200 text-sm font-medium">Total Tabungan</div>
                    <div class="mt-3 text-2xl">💰</div>
                </div>
                <div class="stat-card rounded-2xl p-5 text-center">
                    <div class="text-3xl font-extrabold text-white mb-1">2024</div>
                    <div class="text-green-200 text-sm font-medium">Berdiri Sejak</div>
                    <div class="mt-3 text-2xl">🌱</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave Divider (Tanpa Celah Garis) --}}
    <div class="absolute -bottom-[2px] left-0 right-0 w-full overflow-hidden leading-none z-20 pointer-events-none">
        <svg class="relative block w-full h-14 sm:h-20 md:h-24" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 80L60 66.7C120 53.3 240 26.7 360 20C480 13.3 600 26.7 720 33.3C840 40 960 40 1080 36.7C1200 33.3 1320 26.7 1380 23.3L1440 20V90H1380C1320 90 1200 90 1080 90C960 90 840 90 720 90C600 90 480 90 360 90C240 90 120 90 60 90H0Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

{{-- ============================================================ --}}
{{-- LAYANAN SECTION --}}
{{-- ============================================================ --}}
<section id="layanan" class="py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-brand-700 font-extrabold text-xs uppercase tracking-wider mb-3 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                Apa yang Kami Tawarkan
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mt-1 mb-4">
                Layanan Unggulan Bank Sampah
            </h2>
            <p class="text-gray-500 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Dari setor sampah harian hingga produk daur ulang berkualitas, semua terintegrasi dalam satu platform digital modern.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            {{-- 1. Tabungan Sampah --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-emerald-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group fade-in flex flex-col justify-between">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-70"></div>
                
                <div>
                    {{-- Visual Gambar Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-xl shadow-emerald-500/30 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300 mb-6 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2m0 14v2" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 mb-3">
                            Nilai Ekonomis
                        </span>
                        <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-brand-700 transition mb-3">
                            Tabungan Sampah
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Setor sampah anorganik terpilah dari rumah, dapatkan saldo tabungan rupiah otomatis yang bisa dicairkan kapan saja.
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-center relative z-10">
                    <a href="#harga" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-800 transition">
                        <span>Lihat Harga Sampah</span>
                        <span class="text-sm">&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- 2. Jemput Bentor --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-blue-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group fade-in flex flex-col justify-between">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-70"></div>
                
                <div>
                    {{-- Visual Gambar Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-blue-600 via-sky-500 to-cyan-400 text-white flex items-center justify-center shadow-xl shadow-blue-500/30 group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-300 mb-6 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8h4.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9h3m-3 3h3" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200 mb-3">
                            Jemput ke Rumah
                        </span>
                        <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-blue-700 transition mb-3">
                            Jemput Bentor
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Minta armada bentor kami menjemput sampahmu langsung di depan rumah warga Desa Banjar Rejo (Min. 5 Kg).
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-center relative z-10">
                    <a href="#lokasi" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 hover:text-blue-800 transition">
                        <span>Cek Wilayah & Depo</span>
                        <span class="text-sm">&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- 3. Produk Olahan --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-lime-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group fade-in flex flex-col justify-between">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-lime-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-70"></div>
                
                <div>
                    {{-- Visual Gambar Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-lime-600 via-emerald-500 to-green-400 text-white flex items-center justify-center shadow-xl shadow-lime-500/30 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300 mb-6 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-2.5 0-5 2-5 5a5 5 0 0010 0c0-3-2.5-5-5-5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 13v5" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-lime-50 text-lime-800 border border-lime-200 mb-3">
                            Hasil Olahan Sampah
                        </span>
                        <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-lime-700 transition mb-3">
                            Produk Berkualitas
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Pupuk kompos organik bernutrisi tinggi, POC cair, dan lilin minyak jelantah hasil daur ulang ramah lingkungan.
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-center relative z-10">
                    <a href="#produk" class="inline-flex items-center gap-1.5 text-xs font-bold text-lime-700 hover:text-lime-800 transition">
                        <span>Lihat Katalog Produk</span>
                        <span class="text-sm">&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- 4. Pembayaran Digital --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-purple-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group fade-in flex flex-col justify-between">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none opacity-70"></div>
                
                <div>
                    {{-- Visual Gambar Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-purple-600 via-violet-500 to-indigo-400 text-white flex items-center justify-center shadow-xl shadow-purple-500/30 group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-300 mb-6 relative z-10">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6m-6 3h6" />
                        </svg>
                    </div>

                    <div class="text-center relative z-10">
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-purple-50 text-purple-700 border border-purple-200 mb-3">
                            QRIS & Virtual Gateway
                        </span>
                        <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-purple-700 transition mb-3">
                            Pembayaran Digital
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Beli produk olahan atau cairkan saldo tabungan secara instan melalui sistem pembayaran digital yang mudah & aman.
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-center relative z-10">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-700 hover:text-purple-800 transition">
                        <span>Daftar Nasabah Gratis</span>
                        <span class="text-sm">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- HARGA SAMPAH SECTION --}}
{{-- ============================================================ --}}
<section id="harga" class="py-24 bg-white relative overflow-hidden">
    {{-- Aksen Latar Belakang --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 fade-in">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-brand-700 font-extrabold text-xs uppercase tracking-wider mb-3 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                Transparan & Real-Time dari Database
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mt-1 mb-4">
                Daftar Harga Beli Sampah
            </h2>
            <p class="text-gray-500 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Nilai rupiah langsung yang masuk ke buku tabunganmu per kilogram atau liter sampah yang kamu setor ke bank sampah.
            </p>
        </div>

        @if($kategoriSampah->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 items-stretch">
            @foreach($kategoriSampah as $kategori)
                @if($kategori->sampah->count() > 0)
                @php
                    $katName = strtolower($kategori->nama_kategori);
                    if(str_contains($katName, 'plastik')) {
                        $grad = 'from-teal-600 via-emerald-600 to-teal-500';
                        $accent = 'teal';
                        $iconSvg = '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
                    } elseif(str_contains($katName, 'kertas') || str_contains($katName, 'karton')) {
                        $grad = 'from-amber-600 via-amber-500 to-yellow-500';
                        $accent = 'amber';
                        $iconSvg = '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>';
                    } elseif(str_contains($katName, 'logam') || str_contains($katName, 'kaleng') || str_contains($katName, 'besi')) {
                        $grad = 'from-slate-700 via-zinc-700 to-slate-600';
                        $accent = 'slate';
                        $iconSvg = '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>';
                    } elseif(str_contains($katName, 'jelantah') || str_contains($katName, 'minyak')) {
                        $grad = 'from-orange-600 via-amber-500 to-orange-400';
                        $accent = 'orange';
                        $iconSvg = '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 4H9L8 4z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 8v10a3 3 0 003 3h0a3 3 0 003-3V8" /></svg>';
                    } else {
                        $grad = 'from-emerald-700 via-green-600 to-lime-500';
                        $accent = 'emerald';
                        $iconSvg = '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-2.5 0-5 2-5 5a5 5 0 0010 0c0-3-2.5-5-5-5z" /></svg>';
                    }
                @endphp

                <div class="bg-white rounded-3xl border-2 border-slate-100 hover:border-emerald-500 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden flex flex-col justify-between group fade-in">
                    
                    <div>
                        {{-- Header Kategori dengan Gradasi & Ikon Vektor --}}
                        <div class="bg-gradient-to-r {{ $grad }} px-6 py-4 flex items-center justify-between text-white">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur border border-white/30 flex items-center justify-center shadow-inner">
                                    {!! $iconSvg !!}
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-base leading-tight">{{ $kategori->nama_kategori }}</h3>
                                    <span class="text-[10px] text-white/80 font-medium">{{ $kategori->sampah->count() }} Jenis Komoditas</span>
                                </div>
                            </div>
                        </div>

                        {{-- Daftar Item Komoditas Sampah --}}
                        <div class="p-5 divide-y divide-slate-100">
                            @foreach($kategori->sampah as $s)
                            <div class="py-3.5 first:pt-1 last:pb-1 flex items-center justify-between gap-3 hover:bg-slate-50/70 rounded-xl px-2.5 transition">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-sm text-slate-800 leading-snug line-clamp-1" title="{{ $s->nama_sampah }}">
                                        {{ $s->nama_sampah }}
                                    </p>
                                    @if($s->deskripsi)
                                        <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5 leading-tight">
                                            {{ $s->deskripsi }}
                                        </p>
                                    @else
                                        <p class="text-[11px] text-slate-400 mt-0.5">Kondisi bersih & terpilah</p>
                                    @endif
                                </div>

                                {{-- Tag Harga Tebal (Diambil dari harga_beli_nasabah asli) --}}
                                <div class="text-right flex-shrink-0">
                                    <span class="inline-flex items-baseline gap-1 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-brand-700 shadow-xs">
                                        <span class="font-black text-sm sm:text-base">
                                            Rp {{ number_format($s->harga_beli_nasabah, 0, ',', '.') }}
                                        </span>
                                        <span class="text-[10px] text-emerald-800 font-semibold">
                                            /{{ $s->satuan ?? 'kg' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Footer Mini Tiap Kartu --}}
                    <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                        <span>● Status: Diterima</span>
                        <a href="{{ route('register') }}" class="font-bold text-brand-700 hover:text-brand-800 transition">
                            Mulai Setor &rarr;
                        </a>
                    </div>

                </div>
                @endif
            @endforeach
        </div>
        @else
        <div class="text-center text-gray-400 py-16 bg-slate-50 rounded-3xl border border-slate-200">
            <div class="text-5xl mb-4">📋</div>
            <p class="font-medium">Daftar harga sedang disinkronkan oleh pengelola bank sampah.</p>
        </div>
        @endif

        {{-- Catatan & Call to Action Bawah --}}
        <div class="mt-14 p-6 sm:p-8 bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50 rounded-3xl border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left fade-in">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-brand-600 text-white flex items-center justify-center text-2xl flex-shrink-0 shadow-md">
                    ⚖️
                </div>
                <div>
                    <h4 class="font-extrabold text-gray-900 text-base sm:text-lg">Punya Sampah Menumpuk di Rumah?</h4>
                    <p class="text-gray-500 text-xs sm:text-sm mt-0.5 max-w-xl">
                        Jangan dibakar atau dibuang ke sungai! Timbang langsung ke Depo Banjar Rejo atau panggil armada bentor untuk menjemput.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('register') }}" class="px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-brand-600/20 transition">
                    Daftar Nasabah Gratis
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- PRODUK OLAHAN SECTION --}}
{{-- ============================================================ --}}
@if($produkOlahan->count() > 0)
<section id="produk" class="py-24 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-brand-700 font-extrabold text-xs uppercase tracking-wider mb-3 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                Karya Warga & Daur Ulang
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mt-1 mb-4">
                Produk Hasil Olahan Sampah
            </h2>
            <p class="text-gray-500 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Sampah terkelola bernilai tinggi: pupuk organik subur untuk tanaman dan lilin aromaterapi ramah lingkungan.
            </p>
        </div>

        {{-- Grid 3 Kolom yang Seragam Sempurna (Ukuran Lebar & Tinggi Sama Persis) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            @foreach($produkOlahan as $p)
            @php
                // Tentukan tema warna & ikon SVG berdasarkan nama produk
                $theme = 'emerald';
                $badgeText = 'Pupuk Organik';
                if(str_contains(strtolower($p->nama_produk), 'poc') || str_contains(strtolower($p->nama_produk), 'cair')) {
                    $theme = 'teal';
                    $badgeText = 'POC Cair';
                } elseif(str_contains(strtolower($p->nama_produk), 'lilin') || str_contains(strtolower($p->nama_produk), 'jelantah')) {
                    $theme = 'amber';
                    $badgeText = 'Daur Ulang Jelantah';
                }
            @endphp

            <div class="bg-white rounded-3xl overflow-hidden border-2 border-slate-100 hover:border-emerald-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between h-full group fade-in">
                
                {{-- Bagian Atas: Gambar/Ilustrasi Menarik --}}
                <div class="relative h-52 w-full flex items-center justify-center overflow-hidden
                    {{ $theme === 'emerald' ? 'bg-gradient-to-br from-emerald-500 via-teal-600 to-emerald-700' : ($theme === 'teal' ? 'bg-gradient-to-br from-teal-500 via-cyan-600 to-emerald-600' : 'bg-gradient-to-br from-amber-500 via-orange-500 to-rose-500') }}">
                    
                    {{-- Latar Lingkaran Halus --}}
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>
                    <div class="absolute -left-6 -top-6 w-24 h-24 bg-white/10 rounded-full pointer-events-none"></div>

                    {{-- Badge Kategori Melayang --}}
                    <div class="absolute top-4 left-4 z-10">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/90 backdrop-blur text-slate-800 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full {{ $theme === 'emerald' ? 'bg-emerald-600' : ($theme === 'teal' ? 'bg-teal-600' : 'bg-amber-600') }}"></span>
                            {{ $badgeText }}
                        </span>
                    </div>

                    {{-- Badge Stok Tersedia --}}
                    <div class="absolute top-4 right-4 z-10">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-black/30 backdrop-blur text-white border border-white/20">
                            Stok: {{ $p->stok }} {{ $p->satuan ?? 'pcs' }}
                        </span>
                    </div>

                    {{-- Ilustrasi Ikon SVG Besar --}}
                    <div class="transform group-hover:scale-110 transition-transform duration-300 text-white drop-shadow-lg">
                        @if($theme === 'emerald')
                            {{-- Karung Pupuk Kompos --}}
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M5 10c0-1.105.895-2 2-2h10c1.105 0 2 .895 2 2v9a2 2 0 01-2 2H7a2 2 0 01-2-2v-9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 11c-1.5 0-3 1.2-3 3 0 1.5 1.5 3 3 3s3-1.5 3-3c0-1.8-1.5-3-3-3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 14v4" />
                            </svg>
                        @elseif($theme === 'teal')
                            {{-- Botol Pupuk Organik Cair (POC) --}}
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 4H9L8 4z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 8v10a3 3 0 003 3h0a3 3 0 003-3V8" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 12v3m-1.5-1.5h3" />
                            </svg>
                        @else
                            {{-- Lilin Aromaterapi --}}
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3c-1 1.5-2 3-2 4.5a2 2 0 004 0C14 6 13 4.5 12 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h8a1 1 0 011 1v10a2 2 0 01-2 2H9a2 2 0 01-2-2V10a1 1 0 011-1z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M10 13h4m-4 4h4" />
                            </svg>
                        @endif
                    </div>
                </div>

                {{-- Bagian Bawah: Informasi Produk & Aksi Beli --}}
                <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between">
                    <div>
                        {{-- Judul Produk (Tinggi Terkunci Sama Persis) --}}
                        <h3 class="font-extrabold text-lg text-gray-900 group-hover:text-emerald-700 transition leading-snug h-14 line-clamp-2" title="{{ $p->nama_produk }}">
                            {{ $p->nama_produk }}
                        </h3>

                        {{-- Deskripsi Produk (Tinggi Terkunci Sama Persis) --}}
                        <p class="text-gray-500 text-xs sm:text-sm mt-1 mb-5 leading-relaxed h-12 line-clamp-2">
                            {{ $p->deskripsi ?? 'Produk olahan berkualitas tinggi binaan Bank Sampah Bumi Sai Wawai.' }}
                        </p>
                    </div>

                    <div>
                        {{-- Baris Harga & Kemasan --}}
                        <div class="pt-4 border-t border-slate-100 flex items-baseline justify-between mb-4">
                            <div>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block">Harga Satuan</span>
                                <span class="text-brand-700 font-black text-2xl tracking-tight">
                                    Rp {{ number_format($p->harga_rupiah ?? $p->harga, 0, ',', '.') }}
                                </span>
                            </div>
                            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                                / {{ $p->satuan ?? 'kemasan' }}
                            </span>
                        </div>

                        {{-- Tombol Aksi Beli / Daftar --}}
                        @auth
                        <a href="{{ route('nasabah.katalog') }}"
                           class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-bold rounded-2xl transition shadow-md shadow-brand-600/20 flex items-center justify-center gap-1.5">
                            <span>🛒</span> Beli Produk Ini
                        </a>
                        @else
                        <a href="{{ route('register') }}"
                           class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-bold rounded-2xl transition shadow-md shadow-brand-600/20 flex items-center justify-center gap-1.5">
                            <span>Daftar untuk Membeli</span> &rarr;
                        </a>
                        @endauth
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================ --}}
{{-- CARA KERJA --}}
{{-- ============================================================ --}}
<section class="py-24 bg-white relative overflow-hidden">
    {{-- Background Pattern Halus --}}
    <div class="absolute inset-0 opacity-40 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dot-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                    <circle cx="3" cy="3" r="1.5" fill="#e2e8f0"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dot-grid)"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 fade-in">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-brand-700 font-extrabold text-xs uppercase tracking-wider mb-3 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                Mudah, Praktis & Transparan
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mt-1 mb-4">
                Cara Kerja Bank Sampah
            </h2>
            <p class="text-gray-500 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Hanya butuh 4 langkah mudah untuk mengubah sampah rumah tanggamu menjadi tabungan bernilai ekonomis.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 relative">
            {{-- 1. Pilah Sampah --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-emerald-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative group text-center fade-in flex flex-col justify-between">
                {{-- Badge Nomor Langkah --}}
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-extrabold text-xs shadow-md border-2 border-white z-20">
                    Langkah 01
                </div>

                <div class="pt-2">
                    {{-- Icon Visual Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-xl shadow-emerald-500/30 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-brand-700 transition mb-3">
                        Pilah Sampah
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Pisahkan sampah rumah tangga organik (sisa makanan/dapur) dan anorganik (plastik, kardus, botol, jelantah).
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-semibold text-emerald-700">
                    ✓ Mudah Dimulai di Rumah
                </div>
            </div>

            {{-- 2. Setor / Dijemput --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-blue-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative group text-center fade-in flex flex-col justify-between">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-extrabold text-xs shadow-md border-2 border-white z-20">
                    Langkah 02
                </div>

                <div class="pt-2">
                    {{-- Icon Visual Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-blue-600 via-sky-500 to-cyan-400 text-white flex items-center justify-center shadow-xl shadow-blue-500/30 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300 mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-blue-700 transition mb-3">
                        Setor / Dijemput
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Bawa ke Depo Banjar Rejo atau minta dijemput bentor ke rumah. Petugas akan menimbang secara transparan dan akurat.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-semibold text-blue-700">
                    ✓ Penimbangan Terbuka
                </div>
            </div>

            {{-- 3. Dapat Tabungan --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-amber-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative group text-center fade-in flex flex-col justify-between">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-amber-500 to-yellow-500 text-white font-extrabold text-xs shadow-md border-2 border-white z-20">
                    Langkah 03
                </div>

                <div class="pt-2">
                    {{-- Icon Visual Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-amber-500 via-yellow-500 to-orange-400 text-white flex items-center justify-center shadow-xl shadow-amber-500/30 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-amber-700 transition mb-3">
                        Dapat Tabungan
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Nilai rupiah otomatis dihitung dan langsung tercatat ke dalam buku rekening tabungan digital nasabah detik itu juga.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-semibold text-amber-700">
                    ✓ Otomatis & Real-time
                </div>
            </div>

            {{-- 4. Nikmati Manfaat --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 border-2 border-slate-100 hover:border-purple-500 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative group text-center fade-in flex flex-col justify-between">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-purple-600 to-pink-500 text-white font-extrabold text-xs shadow-md border-2 border-white z-20">
                    Langkah 04
                </div>

                <div class="pt-2">
                    {{-- Icon Visual Besar --}}
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-purple-600 via-pink-500 to-rose-400 text-white flex items-center justify-center shadow-xl shadow-purple-500/30 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300 mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2v2m0 16v2m10-10h-2M4 12H2" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-purple-700 transition mb-3">
                        Nikmati Manfaat
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Cairkan tabungan ke uang tunai/bank/e-Wallet, belanjakan pupuk kompos organik, atau simpan sebagai investasi masa depan.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-semibold text-purple-700">
                    ✓ Saldo Cair Kapan Saja
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- PETA LOKASI DEPO --}}
{{-- ============================================================ --}}
<section id="lokasi" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-in">
            <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Temukan Kami</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">Lokasi Depo Bank Sampah</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Kunjungi kami langsung atau request jemput bentor ke alamat berikut.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-start">
            {{-- Info Kontak --}}
            <div class="space-y-5 fade-in">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm mb-1">Alamat</p>
                            @if($lokasi)
                                <p class="text-gray-600 text-sm">{{ $lokasi->alamat_lengkap }}</p>
                                <p class="text-gray-500 text-xs mt-1">Kec. Batanghari, Kab. Lampung Timur</p>
                            @else
                                <p class="text-gray-600 text-sm">Desa Banjar Rejo, Kec. Batanghari<br>Kab. Lampung Timur</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm mb-1">Jam Operasional</p>
                            <p class="text-gray-600 text-sm">Senin – Jumat: 08.00 – 16.00</p>
                            <p class="text-gray-600 text-sm">Sabtu: 08.00 – 12.00</p>
                            <p class="text-gray-500 text-xs mt-1 text-orange-600 font-medium">* Minggu & Hari Libur Tutup</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-green-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                <path d="M12 0C5.374 0 0 5.373 0 12c0 2.012.512 3.903 1.41 5.558L0 24l6.615-1.39A11.945 11.945 0 0012 24c6.626 0 12-5.373 12-12S18.626 0 12 0zm0 21.818a9.818 9.818 0 01-5.001-1.372l-.359-.214-3.724.783.794-3.636-.233-.374A9.818 9.818 0 012.182 12C2.182 6.591 6.591 2.182 12 2.182S21.818 6.591 21.818 12 17.409 21.818 12 21.818z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm mb-1">WhatsApp</p>
                            <a href="https://wa.me/6285379324445?text=Halo%20Admin%20Bank%20Sampah%20Bumi%20Sai%20Wawai%2C%20saya%20ingin%20bertanya..."
                               target="_blank"
                               class="text-green-600 font-semibold text-sm hover:underline">
                                +62 853-7932-4445
                            </a>
                            <p class="text-gray-500 text-xs mt-1">Respons dalam jam kerja</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Peta Leaflet --}}
            <div class="lg:col-span-2 fade-in">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div id="map" style="height: 380px; width: 100%;"></div>
                    <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span class="text-xs text-gray-500">
                            @if($lokasi)
                                {{ $lokasi->nama_lokasi }} — Koordinat: {{ $lokasi->latitude }}, {{ $lokasi->longitude }}
                            @else
                                Depo Banjar Rejo — Koordinat: -5.0567210, 105.3421500
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- BERITA & EDUKASI --}}
{{-- ============================================================ --}}
@if($beritaEdukasi->count() > 0)
<section id="berita" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-in">
            <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Wawasan & Inspirasi</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-4">Berita & Edukasi</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Pelajari cara memilah sampah yang benar dan manfaat daur ulang untuk lingkunganmu.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($beritaEdukasi as $berita)
            <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl border border-slate-100 hover:border-emerald-300 card-hover fade-in transition-all duration-300 flex flex-col justify-between group">
                <div>
                    {{-- Foto Sampul Artikel --}}
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        @if($berita->gambar_sampul_path && file_exists(public_path($berita->gambar_sampul_path)))
                            <img src="{{ asset($berita->gambar_sampul_path) }}" 
                                 alt="{{ $berita->judul }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-emerald-600/15 via-teal-600/10 to-emerald-700/20 flex items-center justify-center">
                                <span class="text-5xl group-hover:scale-110 transition-transform">📰</span>
                            </div>
                        @endif

                        {{-- Badge Kategori Melayang --}}
                        <div class="absolute top-3.5 left-3.5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-white/95 backdrop-blur text-emerald-800 shadow-sm border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                {{ ucfirst($berita->kategori ?? 'Edukasi') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs text-slate-400 mb-2.5">
                            <span class="font-medium">
                                📅 {{ $berita->created_at ? $berita->created_at->locale('id')->isoFormat('D MMMM YYYY') : '-' }}
                            </span>
                            @if($berita->dilihat)
                            <span class="text-[11px]">
                                👁️ {{ number_format($berita->dilihat) }} pembaca
                            </span>
                            @endif
                        </div>
                        <h3 class="font-extrabold text-base sm:text-lg text-slate-900 mb-2 line-clamp-2 leading-snug group-hover:text-emerald-700 transition">
                            {{ $berita->judul }}
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm line-clamp-3 leading-relaxed mb-4">
                            {{ $berita->ringkasan }}
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-0">
                    <a href="{{ route('artikel.show', $berita->slug) }}"
                       class="inline-flex items-center gap-1.5 text-emerald-700 font-extrabold text-xs sm:text-sm hover:text-emerald-800 transition group/link">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================ --}}
{{-- MASKOT RESMI: SI WAWAI --}}
{{-- ============================================================ --}}
<section class="py-24 bg-gradient-to-b from-slate-50 via-emerald-50/40 to-white relative overflow-hidden border-t border-emerald-100/60">
    {{-- Aksen Latar Belakang --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-200/25 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-200/25 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 fade-in">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-xs uppercase tracking-wider mb-3 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                Karakter Ikonik Desa Banjar Rejo
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mt-1 mb-4">
                Kenalan dengan <span class="text-emerald-700 underline decoration-emerald-400">Si Wawai</span>! 🌿
            </h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Maskot resmi Bank Sampah Bumi Sai Wawai yang selalu setia memandu warga desa memilah sampah, menabung berkah, dan menjaga kelestarian alam.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            {{-- Pose 1: Si Wawai Menyambut --}}
            <div class="bg-white rounded-3xl p-7 border-2 border-emerald-100 hover:border-emerald-500 shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group fade-in text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-28 h-28 bg-emerald-50 rounded-bl-full -z-0 group-hover:scale-125 transition-transform"></div>
                
                <div class="relative z-10">
                    <div class="w-36 h-36 mx-auto mb-4 relative flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full bg-emerald-400/20 blur-xl group-hover:bg-emerald-400/40 transition"></div>
                        <img src="{{ asset('images/mascot/siwawai-welcome.webp') }}" 
                             alt="Si Wawai Menyambut" 
                             class="w-full h-full object-contain filter drop-shadow-lg transform group-hover:scale-110 transition duration-300">
                    </div>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-2">
                        Pose 1 &bull; Ramah Menyapa
                    </span>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-2">Si Wawai Menyambut</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Selalu siap dengan senyuman lebar dan tangan terbuka menyambut setiap nasabah yang datang ke depo bank sampah maupun yang baru mendaftar online.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="window.triggerSiWawaiMascot ? window.triggerSiWawaiMascot('Halo warga Banjar Rejo! Senang sekali bisa menyambutmu di Bank Sampah Bumi Sai Wawai! 🌱', 'welcome') : reactSiWawai()"
                            class="w-full py-2.5 px-4 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white text-xs font-bold transition shadow-xs">
                        Sapa Si Wawai 👋
                    </button>
                </div>
            </div>

            {{-- Pose 2: Si Wawai Memandu / Menunjuk --}}
            <div class="bg-white rounded-3xl p-7 border-2 border-emerald-200/90 hover:border-emerald-500 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group fade-in text-center relative overflow-hidden ring-2 ring-emerald-500/20">
                <div class="absolute top-3 right-3 z-10">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-600 text-white shadow-sm">
                        ⭐ Favorit Edukasi
                    </span>
                </div>
                <div class="absolute top-0 right-0 w-28 h-28 bg-teal-50 rounded-bl-full -z-0 group-hover:scale-125 transition-transform"></div>

                <div class="relative z-10">
                    <div class="w-36 h-36 mx-auto mb-4 relative flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full bg-teal-400/20 blur-xl group-hover:bg-teal-400/40 transition"></div>
                        <img src="{{ asset('images/mascot/siwawai-point.webp') }}" 
                             alt="Si Wawai Mengarahkan" 
                             class="w-full h-full object-contain filter drop-shadow-lg transform group-hover:scale-110 transition duration-300">
                    </div>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-teal-100 text-teal-800 mb-2">
                        Pose 2 &bull; Cermat Menunjuk
                    </span>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-2">Si Wawai Edukator</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Cermat mengarahkan warga cara memilah jenis sampah, mengecek harga terkini, dan mencairkan saldo ke dompet digital tanpa biaya admin.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="window.triggerSiWawaiMascot ? window.triggerSiWawaiMascot('Ingat ya! Pisahkan sampah plastik bersih dan kering agar harga jualnya maksimal di timbangan! 💡', 'point') : reactSiWawai()"
                            class="w-full py-2.5 px-4 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition shadow-sm">
                        Minta Tips Edukasi 💡
                    </button>
                </div>
            </div>

            {{-- Pose 3: Si Wawai Juara Kelestarian --}}
            <div class="bg-white rounded-3xl p-7 border-2 border-emerald-100 hover:border-emerald-500 shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group fade-in text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-28 h-28 bg-emerald-50 rounded-bl-full -z-0 group-hover:scale-125 transition-transform"></div>

                <div class="relative z-10">
                    <div class="w-36 h-36 mx-auto mb-4 relative flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full bg-emerald-400/20 blur-xl group-hover:bg-emerald-400/40 transition"></div>
                        <img src="{{ asset('images/mascot/siwawai-proud.webp') }}" 
                             alt="Si Wawai Bangga Melestarikan" 
                             class="w-full h-full object-contain filter drop-shadow-lg transform group-hover:scale-110 transition duration-300">
                    </div>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-2">
                        Pose 3 &bull; Bangga Berkelestarian
                    </span>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-2">Si Wawai Sang Juara</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Bangga memegang ember hasil pilahan warga yang siap didaur ulang menjadi produk bernilai tinggi seperti kompos kasgot dan pupuk organik cair.
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="window.triggerSiWawaiMascot ? window.triggerSiWawaiMascot('Ember pilahan ini adalah bukti cinta kita pada kelestarian Desa Banjar Rejo! Bangga jadi pahlawan lingkungan! 🏆', 'proud') : reactSiWawai()"
                            class="w-full py-2.5 px-4 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white text-xs font-bold transition shadow-xs">
                        Lihat Semangat Si Wawai 🏆
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- CTA SECTION --}}
{{-- ============================================================ --}}
<section class="py-20 bg-gradient-to-r from-brand-700 to-brand-600 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dots" width="30" height="30" patternUnits="userSpaceOnUse">
                    <circle cx="15" cy="15" r="2" fill="white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dots)"/>
        </svg>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="text-6xl mb-6">🌍</div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
            Bergabunglah Bersama Kami
        </h2>
        <p class="text-green-100 text-lg mb-8 max-w-2xl mx-auto">
            Jadilah bagian dari gerakan lingkungan bersih Lampung Timur. Daftarkan dirimu sekarang dan mulai tabungan sampahmu hari ini!
        </p>
        @guest
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-brand-700 font-bold rounded-2xl shadow-lg hover:shadow-xl hover:bg-green-50 transition text-base">
                🎉 Daftar Sekarang — Gratis!
            </a>
            <a href="https://wa.me/6285379324445?text=Halo%20Admin%2C%20saya%20ingin%20bergabung%20dengan%20Bank%20Sampah%20Bumi%20Sai%20Wawai"
               target="_blank"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-white/40 text-white font-semibold rounded-2xl hover:bg-white/10 transition text-base">
                💬 Tanya via WhatsApp
            </a>
        </div>
        @else
        <a href="{{ route('dashboard.redirect') }}"
           class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-brand-700 font-bold rounded-2xl shadow-lg hover:shadow-xl hover:bg-green-50 transition text-base">
            Ke Dashboard Saya →
        </a>
        @endguest
    </div>
</section>

{{-- ============================================================ --}}
{{-- FOOTER --}}
{{-- ============================================================ --}}
<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo-circle.png') }}" alt="Logo Bank Sampah" class="w-10 h-10 rounded-full shadow border border-emerald-400/30 object-cover">
                    <div>
                        <p class="text-white font-bold leading-tight">Bank Sampah Bumi Sai Wawai</p>
                        <p class="text-brand-400 text-xs">Desa Banjar Rejo, Lampung Timur</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm mb-5">
                    Mewujudkan lingkungan bersih dan masyarakat sejahtera melalui pengelolaan sampah yang terkelola, transparan, dan bernilai ekonomis.
                </p>
                <a href="https://wa.me/6285379324445" target="_blank"
                   class="inline-flex items-center gap-2 text-sm text-green-400 hover:text-green-300 font-semibold transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    </svg>
                    +62 853-7932-4445
                </a>
            </div>

            {{-- Navigasi --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#layanan" class="hover:text-white transition">Layanan</a></li>
                    <li><a href="#harga" class="hover:text-white transition">Harga Sampah</a></li>
                    <li><a href="#produk" class="hover:text-white transition">Produk Olahan</a></li>
                    <li><a href="#lokasi" class="hover:text-white transition">Lokasi</a></li>
                    <li><a href="#berita" class="hover:text-white transition">Berita & Edukasi</a></li>
                </ul>
            </div>

            {{-- Akun --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Akun</h4>
                <ul class="space-y-2 text-sm">
                    @guest
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Masuk</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar Nasabah</a></li>
                    @else
                    <li><a href="{{ route('dashboard.redirect') }}" class="hover:text-white transition">Dashboard</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-white transition">Keluar</button>
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-10 pt-6 text-center">
            <p class="text-gray-500 text-xs">
                &copy; {{ date('Y') }} Bank Sampah Bumi Sai Wawai. Dibuat dengan ❤️ untuk lingkungan yang lebih baik.
            </p>
        </div>
    </div>
</footer>

{{-- ============================================================ --}}
{{-- FLOATING WHATSAPP BUTTON --}}
{{-- ============================================================ --}}
<a href="https://wa.me/6285379324445?text=Halo%20Admin%20Bank%20Sampah%20Bumi%20Sai%20Wawai%2C%20saya%20ingin%20bertanya..."
   target="_blank"
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110 group"
   title="Chat via WhatsApp">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.374 0 0 5.373 0 12c0 2.012.512 3.903 1.41 5.558L0 24l6.615-1.39A11.945 11.945 0 0012 24c6.626 0 12-5.373 12-12S18.626 0 12 0zm0 21.818a9.818 9.818 0 01-5.001-1.372l-.359-.214-3.724.783.794-3.636-.233-.374A9.818 9.818 0 012.182 12C2.182 6.591 6.591 2.182 12 2.182S21.818 6.591 21.818 12 17.409 21.818 12 21.818z"/>
    </svg>
    <span class="absolute right-16 bg-gray-900 text-white text-xs px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition">
        Chat WhatsApp
    </span>
</a>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// ============================================================
// Leaflet Map
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    @if($lokasi)
        var lat  = {{ $lokasi->latitude }};
        var lng  = {{ $lokasi->longitude }};
        var nama = "{{ $lokasi->nama_lokasi }}";
        var alamat = "{{ $lokasi->alamat_lengkap }}";
    @else
        var lat  = -5.0567210;
        var lng  = 105.3421500;
        var nama = "Depo Bank Sampah Bumi Sai Wawai";
        var alamat = "Desa Banjar Rejo, Kec. Batanghari, Kab. Lampung Timur";
    @endif

    var map = L.map('map').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    // Custom marker icon
    var icon = L.divIcon({
        html: '<div style="background:#059669;width:36px;height:36px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3)"><div style="transform:rotate(45deg);display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:16px;">♻️</div></div>',
        className: '',
        iconSize: [36, 36],
        iconAnchor: [18, 36],
        popupAnchor: [0, -40]
    });

    L.marker([lat, lng], {icon: icon})
        .addTo(map)
        .bindPopup(
            '<div style="font-family:\'Plus Jakarta Sans\',sans-serif;min-width:200px;">' +
            '<strong style="color:#065f46;font-size:13px;">' + nama + '</strong><br>' +
            '<span style="color:#6b7280;font-size:12px;">' + alamat + '</span><br><br>' +
            '<a href="https://maps.google.com/?q=' + lat + ',' + lng + '" target="_blank" ' +
            'style="background:#059669;color:white;padding:4px 10px;border-radius:6px;font-size:12px;text-decoration:none;">📍 Buka di Google Maps</a>' +
            '</div>',
            {maxWidth: 250}
        )
        .openPopup();
});

// ============================================================
// Scroll Fade-In Animation
// ============================================================
(function() {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(function(el) {
        observer.observe(el);
    });
})();

// ============================================================
// Smooth Scroll for Anchor Links
// ============================================================
document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        var target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>

{{-- Maskot Interaktif Si Wawai --}}
@include('components.mascot-siwawai')

</body>
</html>

