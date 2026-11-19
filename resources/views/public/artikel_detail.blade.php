<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->judul }} – Bank Sampah Bumi Sai Wawai</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .article-body p  { margin-bottom: 1.2rem; line-height: 1.8; color: #374151; }
        .article-body h2 { font-size: 1.3rem; font-weight: 700; color: #111827; margin: 2rem 0 0.75rem; }
        .article-body h3 { font-size: 1.1rem; font-weight: 600; color: #111827; margin: 1.5rem 0 0.5rem; }
        .article-body ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1.2rem; color: #374151; }
        .article-body li { margin-bottom: 0.4rem; line-height: 1.7; }
        .article-body strong { color: #065f46; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

{{-- Navbar --}}
<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z"/>
                </svg>
            </div>
            <span class="text-sm font-bold text-gray-900 hidden sm:block">Bank Sampah Bumi Sai Wawai</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#berita" class="text-sm text-gray-500 hover:text-emerald-700 transition">← Semua Artikel</a>
            @guest
            <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">Daftar</a>
            @else
            <a href="{{ route('dashboard.redirect') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">Dashboard</a>
            @endguest
        </div>
    </div>
</nav>

{{-- Main --}}
<main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-3 gap-10">

        {{-- Article Body --}}
        <article class="lg:col-span-2">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 border border-emerald-100 px-3 py-1 rounded-full">
                        {{ $artikel->kategori ?? 'Edukasi' }}
                    </span>
                    <span class="text-xs text-gray-400">
                        {{ $artikel->created_at ? $artikel->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY') : '-' }}
                    </span>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight mb-4">
                    {{ $artikel->judul }}
                </h1>
                @if($artikel->ringkasan)
                <p class="text-gray-500 text-lg border-l-4 border-emerald-400 pl-4 leading-relaxed">
                    {{ $artikel->ringkasan }}
                </p>
                @endif
            </div>

            {{-- Cover --}}
            @if($artikel->gambar_sampul_path && file_exists(public_path($artikel->gambar_sampul_path)))
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-100 mb-8 max-h-[420px]">
                    <img src="{{ asset($artikel->gambar_sampul_path) }}" 
                         alt="{{ $artikel->judul }}" 
                         class="w-full h-full object-cover">
                </div>
            @else
                <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200 h-56 flex items-center justify-center mb-8">
                    <span class="text-7xl">📰</span>
                </div>
            @endif

            {{-- Content --}}
            <div class="article-body bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                {!! nl2br(e($artikel->konten)) !!}
            </div>

            {{-- Share & Back --}}
            <div class="mt-8 flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('home') }}#berita"
                   class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-emerald-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Semua Artikel
                </a>
                <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . url()->current()) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-700 font-semibold transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.374 0 0 5.373 0 12c0 2.012.512 3.903 1.41 5.558L0 24l6.615-1.39A11.945 11.945 0 0012 24c6.626 0 12-5.373 12-12S18.626 0 12 0z"/>
                    </svg>
                    Bagikan via WhatsApp
                </a>
            </div>
        </article>

        {{-- Sidebar --}}
        <aside class="space-y-6">
            {{-- Artikel Lainnya --}}
            @if($artikelLain->count() > 0)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Artikel Lainnya</h3>
                <div class="space-y-4">
                    @foreach($artikelLain as $lain)
                    <a href="{{ route('artikel.show', $lain->slug) }}" class="flex gap-3 group">
                        <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0 text-2xl">
                            📄
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                {{ $lain->judul }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $lain->created_at ? $lain->created_at->locale('id')->isoFormat('D MMM YYYY') : '-' }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- CTA Box --}}
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-5 text-white">
                <div class="text-3xl mb-3">🌱</div>
                <h3 class="font-bold mb-2">Mulai Tabungan Sampahmu!</h3>
                <p class="text-emerald-100 text-sm mb-4">Daftar gratis dan mulai ubah sampahmu menjadi uang.</p>
                @guest
                <a href="{{ route('register') }}"
                   class="block text-center py-2.5 bg-white text-emerald-700 font-bold rounded-xl text-sm hover:bg-green-50 transition">
                    Daftar Sekarang
                </a>
                @else
                <a href="{{ route('dashboard.redirect') }}"
                   class="block text-center py-2.5 bg-white text-emerald-700 font-bold rounded-xl text-sm hover:bg-green-50 transition">
                    Ke Dashboard →
                </a>
                @endguest
            </div>

            {{-- Kontak --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-3 text-sm uppercase tracking-wide">Hubungi Kami</h3>
                <a href="https://wa.me/6285379324445" target="_blank"
                   class="flex items-center gap-3 text-sm text-green-700 hover:text-green-800 font-semibold transition">
                    <span class="text-2xl">💬</span>
                    +62 853-7932-4445
                </a>
                <p class="text-xs text-gray-400 mt-2">Senin–Jumat 08.00–16.00 WIB</p>
            </div>
        </aside>

    </div>
</main>

{{-- Footer mini --}}
<footer class="bg-gray-900 text-gray-400 text-center text-xs py-5 mt-14">
    &copy; {{ date('Y') }} Bank Sampah Bumi Sai Wawai. Semua hak dilindungi.
</footer>

{{-- Floating WA --}}
<a href="https://wa.me/6285379324445?text=Halo%20Admin%20Bank%20Sampah%2C%20saya%20ingin%20bertanya..."
   target="_blank"
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.374 0 0 5.373 0 12c0 2.012.512 3.903 1.41 5.558L0 24l6.615-1.39A11.945 11.945 0 0012 24c6.626 0 12-5.373 12-12S18.626 0 12 0z"/>
    </svg>
</a>

</body>
</html>

