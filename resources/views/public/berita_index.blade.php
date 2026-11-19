<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Edukasi Lingkungan – Bank Sampah Bumi Sai Wawai</title>
    <meta name="description" content="Arsip artikel, panduan memilah sampah, dan berita kegiatan Bank Sampah Bumi Sai Wawai di Desa Banjar Rejo, Batanghari, Lampung Timur.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
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
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    {{-- NAVBAR PUBLIK --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-xs border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-10 h-10 rounded-full border border-emerald-500/30 object-cover shadow-sm group-hover:scale-105 transition">
                <div>
                    <h2 class="font-extrabold text-sm leading-tight text-slate-900 group-hover:text-emerald-700 transition">Bank Sampah</h2>
                    <p class="text-xs text-emerald-600 font-bold">Bumi Sai Wawai</p>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                <a href="{{ route('home') }}" class="hover:text-emerald-700 transition">Beranda</a>
                <a href="{{ route('home') }}#harga" class="hover:text-emerald-700 transition">Daftar Harga</a>
                <a href="{{ route('home') }}#produk" class="hover:text-emerald-700 transition">Produk Daur Ulang</a>
                <a href="{{ route('berita.index') }}" class="text-emerald-700 font-extrabold border-b-2 border-emerald-600 pb-1">Berita & Edukasi</a>
                <a href="{{ route('home') }}#lokasi" class="hover:text-emerald-700 transition">Lokasi Depo</a>
            </div>

            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-emerald-700 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-700/20 transition">
                        Daftar Nasabah
                    </a>
                @else
                    <a href="{{ route('dashboard.redirect') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-700/20 transition flex items-center gap-1.5">
                        <span>📊</span> Buka Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- HERO BANNER & FORM PENCARIAN --}}
    <header class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 text-white py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        {{-- Decorative blur --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10 space-y-4">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-800/80 border border-emerald-600/50 text-emerald-300 font-extrabold text-xs uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Pusat Informasi & Literasi Lingkungan
            </span>

            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                Berita, Panduan & Edukasi Warga
            </h1>

            <p class="text-sm sm:text-base text-emerald-100/85 max-w-2xl mx-auto leading-relaxed">
                Pelajari kiat praktis memilah sampah rumah tangga, inovasi daur ulang bernilai rupiah, dan warta kegiatan resmi Bank Sampah Bumi Sai Wawai di Desa Banjar Rejo.
            </p>

            {{-- Form Pencarian Cepat --}}
            <form method="GET" action="{{ route('berita.index') }}" class="pt-4 max-w-xl mx-auto">
                <div class="flex items-center gap-2 bg-white rounded-2xl p-1.5 shadow-xl border border-white/20">
                    <span class="pl-3 text-slate-400 text-base">🔍</span>
                    <input type="text" name="cari" value="{{ $search ?? '' }}" placeholder="Cari topik artikel (misal: plastik, jelantah, e-wallet)..."
                        class="flex-1 px-2 py-2 text-xs sm:text-sm text-slate-800 outline-none bg-transparent placeholder:text-slate-400">
                    @if ($kategori)
                        <input type="hidden" name="kategori" value="{{ $kategori }}">
                    @endif
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition whitespace-nowrap">
                        Cari Artikel
                    </button>
                </div>
            </form>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full">

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-5 border-b border-slate-200">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('berita.index', array_filter(['cari' => $search])) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs {{ empty($kategori) ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    Semua ({{ $totalSemuaBerita }})
                </a>
                @foreach ($kategoriList as $kat)
                    @php $isActive = ($kategori === $kat); @endphp
                    <a href="{{ route('berita.index', array_filter(['kategori' => $kat, 'cari' => $search])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-xs {{ $isActive ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        {{ ucfirst($kat) }}
                    </a>
                @endforeach
            </div>

            @if ($search || $kategori)
                <a href="{{ route('berita.index') }}" class="text-xs font-bold text-rose-600 hover:underline flex items-center gap-1">
                    <span>✕</span> Reset Filter
                </a>
            @endif
        </div>

        {{-- Header Status Pencarian --}}
        @if ($search)
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-center justify-between">
                <span>Hasil pencarian untuk kata kunci: <b class="font-extrabold">"{{ $search }}"</b></span>
                <span class="font-semibold">{{ $beritaList->total() }} artikel ditemukan</span>
            </div>
        @endif

        {{-- Grid Artikel --}}
        @if ($beritaList->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                @foreach ($beritaList as $berita)
                    <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl border border-slate-200/80 hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            {{-- Foto Sampul Artikel --}}
                            <div class="relative h-52 overflow-hidden bg-slate-100">
                                @if ($berita->gambar_sampul_path && file_exists(public_path($berita->gambar_sampul_path)))
                                    <img src="{{ asset($berita->gambar_sampul_path) }}" 
                                         alt="{{ $berita->judul }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-600/15 via-teal-600/10 to-emerald-700/20 flex items-center justify-center">
                                        <span class="text-5xl group-hover:scale-110 transition-transform">📰</span>
                                    </div>
                                @endif

                                {{-- Badge Kategori --}}
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
                                    @if ($berita->dilihat)
                                        <span class="text-[11px] text-slate-500">
                                            👁️ {{ number_format($berita->dilihat) }} pembaca
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-extrabold text-base sm:text-lg text-slate-900 mb-2.5 line-clamp-2 leading-snug group-hover:text-emerald-700 transition">
                                    <a href="{{ route('artikel.show', $berita->slug) }}">
                                        {{ $berita->judul }}
                                    </a>
                                </h3>

                                <p class="text-slate-600 text-xs sm:text-sm line-clamp-3 leading-relaxed mb-4">
                                    {{ $berita->ringkasan }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-0 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">
                                Oleh: <b class="text-slate-600">{{ $berita->penulis->nama_lengkap ?? 'Pengelola' }}</b>
                            </span>
                            <a href="{{ route('artikel.show', $berita->slug) }}"
                               class="inline-flex items-center gap-1 text-emerald-700 font-extrabold text-xs sm:text-sm hover:text-emerald-800 transition group/link">
                                <span>Baca Selengkapnya</span>
                                <span class="group-hover/link:translate-x-1 transition-transform">→</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($beritaList->hasPages())
                <div class="mt-12 pt-6 border-t border-slate-200">
                    {{ $beritaList->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-3xl p-16 text-center border border-slate-200 max-w-lg mx-auto shadow-sm my-8">
                <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center text-4xl mx-auto mb-4">
                    🔍
                </div>
                <h3 class="font-extrabold text-slate-800 text-base mb-1">Tidak Ada Artikel Ditemukan</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-6">
                    Maaf, tidak ada artikel yang sesuai dengan pencarian atau filter kategori yang dipilih.
                </p>
                <a href="{{ route('berita.index') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition">
                    Tampilkan Semua Artikel
                </a>
            </div>
        @endif

    </main>

    {{-- FOOTER PUBLIK --}}
    <footer class="bg-slate-900 text-white pt-14 pb-8 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 pb-10 border-b border-slate-800 text-xs">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-9 h-9 rounded-full border border-emerald-400/40">
                    <div>
                        <h4 class="font-extrabold text-sm text-white">Bank Sampah Bumi Sai Wawai</h4>
                        <p class="text-[11px] text-emerald-400">Desa Banjar Rejo, Batanghari</p>
                    </div>
                </div>
                <p class="text-slate-400 leading-relaxed">
                    Mewujudkan lingkungan bersih dan ekonomi berkah melalui pemilahan sampah terintegrasi digital di Lampung Timur.
                </p>
            </div>
            <div>
                <h4 class="font-bold text-sm text-white mb-3">Navigasi Utama</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Beranda Utama</a></li>
                    <li><a href="{{ route('home') }}#harga" class="hover:text-emerald-400 transition">Daftar Harga Beli Sampah</a></li>
                    <li><a href="{{ route('home') }}#produk" class="hover:text-emerald-400 transition">Produk Olahan Pupuk & Lilin</a></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:text-emerald-400 transition text-emerald-300 font-bold">Semua Berita & Edukasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-sm text-white mb-3">Kontak & Layanan Depo</h4>
                <p class="text-slate-400 leading-relaxed">
                    Kantor Depo: RT 01 / RW 02, Desa Banjar Rejo, Kec. Batanghari, Kab. Lampung Timur.<br>
                    WhatsApp Layanan: <b class="text-white">+62 853-7932-4445</b>
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} Bank Sampah Bumi Sai Wawai. Seluruh hak cipta dilindungi undang-undang.
        </div>
    </footer>

    {{-- Maskot Si Wawai --}}
    @include('components.mascot-siwawai')
</body>
</html>