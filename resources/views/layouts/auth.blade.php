<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') - Bank Sampah Bumi Sai Wawai</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
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
</head>
<body class="min-h-screen font-sans text-slate-800 bg-white antialiased selection:bg-emerald-500 selection:text-white">

    {{-- ======================================================== --}}
    {{-- FULL-SCREEN EDGE-TO-EDGE AUTH SPLIT LAYOUT               --}}
    {{-- ======================================================== --}}
    <div class="min-h-screen w-full flex flex-col lg:flex-row">

        {{-- ---------------------------------------------------- --}}
        {{-- SISI KIRI: GAMBAR DESAIN RESMI BANK SAMPAH (FULL)    --}}
        {{-- ---------------------------------------------------- --}}
        <div class="w-full lg:w-1/2 xl:w-7/12 relative bg-[#0a3828] min-h-[260px] sm:min-h-[340px] lg:min-h-screen flex flex-col justify-end overflow-hidden group flex-shrink-0">
            
            {{-- Gambar Desain User (Otomatis WebP + Fallback JPG) Full Cover --}}
            <picture class="absolute inset-0 w-full h-full">
                <source srcset="{{ asset('images/auth-hero.webp') }}" type="image/webp">
                <img src="{{ asset('images/auth-hero.jpg') }}"
                     alt="Bank Sampah Bumi Sai Wawai"
                     class="w-full h-full object-cover object-center transform group-hover:scale-[1.01] transition-transform duration-700 ease-out"
                     loading="eager">
            </picture>

            {{-- Vignette & Dark Gradient halus agar kontras menyatu --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/15 pointer-events-none"></div>

            {{-- Badge Info Desa di pojok kiri bawah foto --}}
            <div class="relative z-10 m-4 sm:m-6 lg:m-8 flex items-center gap-2.5 px-3.5 py-2 rounded-full bg-black/45 backdrop-blur-md border border-white/20 text-white text-xs font-semibold w-fit shadow-xl">
                <span class="w-2.5 h-2.5 rounded-full bg-lime-400 animate-pulse"></span>
                <span>Desa Banjar Rejo, Batanghari, Lampung Timur</span>
            </div>
        </div>

        {{-- ---------------------------------------------------- --}}
        {{-- SISI KANAN: FORM AUTH (LOGIN / REGISTER) FULL HEIGHT --}}
        {{-- ---------------------------------------------------- --}}
        <div class="w-full lg:w-1/2 xl:w-5/12 min-h-screen flex flex-col justify-between bg-white px-6 sm:px-12 lg:px-14 xl:px-16 py-8 sm:py-12 overflow-y-auto">

            {{-- Spacer Atas --}}
            <div class="hidden lg:block"></div>

            {{-- Kontainer Form Tengah --}}
            <div class="max-w-md w-full mx-auto my-auto py-4">

                {{-- Mobile Brand Header --}}
                <div class="lg:hidden flex items-center gap-3 pb-5 mb-5 border-b border-slate-100">
                    <img src="{{ asset('images/logo-circle.png') }}"
                         alt="Logo Bank Sampah"
                         class="w-11 h-11 rounded-full shadow-md border-2 border-emerald-500/30">
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-800 leading-tight">Bank Sampah Bumi Sai Wawai</h2>
                        <p class="text-[11px] text-emerald-700 font-semibold">Desa Banjar Rejo &bull; Lampung Timur</p>
                    </div>
                </div>

                {{-- Flash Message Alerts --}}
                @if (session('success'))
                    <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-start gap-2.5 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-2.5 shadow-sm">
                        <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Content Utama (Form) --}}
                @yield('content')
            </div>

            {{-- Footer Credit Bawah --}}
            <div class="max-w-md w-full mx-auto pt-6 text-center text-xs text-slate-400 border-t border-slate-100">
                &copy; {{ date('Y') }} Bank Sampah Bumi Sai Wawai &bull; Banjar Rejo, Batanghari
            </div>

        </div>

    </div>

    @stack('scripts')
</body>
</html>
