<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Harga Sampah - Bank Sampah Bumi Sai Wawai</title>
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
        <div class="relative z-10 max-w-5xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('nasabah.dashboard') }}" class="p-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-600 transition text-sm">
                    &larr; Kembali
                </a>
                <h1 class="font-bold text-base">Daftar Harga Komoditas Sampah</h1>
            </div>
            <span class="text-xs text-emerald-200">Update Terkini</span>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8 flex-1 w-full space-y-6">
        @foreach ($kategori as $kat)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <div class="mb-4">
                    <h2 class="text-base font-bold text-emerald-800">{{ $kat->nama_kategori }}</h2>
                    <p class="text-xs text-slate-500">{{ $kat->deskripsi }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse ($kat->sampah as $s)
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-xs text-slate-800">{{ $s->nama_sampah }}</h3>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $s->deskripsi }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-extrabold text-emerald-700">Rp {{ number_format($s->harga_beli_nasabah, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-slate-400 block">/ {{ $s->satuan }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada komoditas di kategori ini.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </main>

    {{-- Maskot Interaktif Si Wawai --}}
    @include('components.mascot-siwawai')
</body>
</html>

