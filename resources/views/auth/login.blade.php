@extends('layouts.auth')

@section('title', 'Masuk ke Sistem')

@section('content')

    {{-- Top Action: Kembali ke Beranda --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-emerald-700 transition-colors group">
            <span class="w-7 h-7 rounded-full bg-slate-100 group-hover:bg-emerald-50 text-slate-600 group-hover:text-emerald-700 flex items-center justify-center transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </span>
            Kembali ke Beranda
        </a>

        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-[11px] font-semibold text-emerald-700">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistem Aktif
        </span>
    </div>

    {{-- Heading --}}
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
            Selamat Datang! 👋
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Silakan masuk dengan akun terdaftar Anda untuk mengakses sistem.
        </p>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Alamat Email
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input type="email" id="email" name="email"
                    value="{{ old('email') }}"
                    required autofocus
                    placeholder="nama@email.com"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-600 transition duration-150 @error('email') border-rose-400 ring-rose-200 @enderror">
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Kata Sandi
                </label>
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input type="password" id="password" name="password"
                    required
                    placeholder="••••••••"
                    class="w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-600 transition duration-150 @error('password') border-rose-400 ring-rose-200 @enderror">
                
                {{-- Toggle Eye Password --}}
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                    <svg id="eyeIcon" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between pt-0.5">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" id="remember" name="remember"
                    class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                <span class="text-xs text-slate-600 font-medium">Ingat saya</span>
            </label>
        </div>

        {{-- Submit Button --}}
        <button type="submit"
            class="w-full mt-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.99] text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 transition-all duration-150 flex items-center justify-center gap-2">
            <span>Masuk ke Dashboard</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>
    </form>

    {{-- Register Link --}}
    <div class="mt-5 text-center">
        <p class="text-xs text-slate-500">
            Belum menjadi nasabah? 
            <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:text-emerald-800 hover:underline">
                Daftar Sekarang (Cepat &amp; Gratis)
            </a>
        </p>
    </div>

    {{-- Akun Demo Helper --}}
    <div class="mt-6 pt-5 border-t border-slate-100">
        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            Klik untuk Mengisi Akun Demo Otomatis:
        </p>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="fillDemo('nasabah@saiwawai.id', 'password123')"
                class="demo-btn text-left px-3 py-2 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 hover:border-emerald-300 transition-all group">
                <div class="text-xs font-bold text-slate-700 group-hover:text-emerald-800 flex items-center gap-1.5">
                    <span>👤</span> Nasabah
                </div>
                <div class="text-[10px] text-slate-400 group-hover:text-emerald-600">Akun Warga</div>
            </button>

            <button type="button" onclick="fillDemo('admin@saiwawai.id', 'password123')"
                class="demo-btn text-left px-3 py-2 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/80 hover:border-blue-300 transition-all group">
                <div class="text-xs font-bold text-slate-700 group-hover:text-blue-800 flex items-center gap-1.5">
                    <span>⚖️</span> Staf Admin
                </div>
                <div class="text-[10px] text-slate-400 group-hover:text-blue-600">Pengelola Depo</div>
            </button>

            <button type="button" onclick="fillDemo('keuangan@saiwawai.id', 'password123')"
                class="demo-btn text-left px-3 py-2 rounded-xl bg-slate-50 hover:bg-amber-50 border border-slate-200/80 hover:border-amber-300 transition-all group">
                <div class="text-xs font-bold text-slate-700 group-hover:text-amber-800 flex items-center gap-1.5">
                    <span>💰</span> Keuangan
                </div>
                <div class="text-[10px] text-slate-400 group-hover:text-amber-600">Kas &amp; Saldo</div>
            </button>

            <button type="button" onclick="fillDemo('pimpinan@saiwawai.id', 'password123')"
                class="demo-btn text-left px-3 py-2 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-300 transition-all group">
                <div class="text-xs font-bold text-slate-700 group-hover:text-purple-800 flex items-center gap-1.5">
                    <span>👑</span> Pimpinan
                </div>
                <div class="text-[10px] text-slate-400 group-hover:text-purple-600">Manajer/Direktur</div>
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        function fillDemo(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
            const btn = event.currentTarget;
            btn.classList.add('ring-2', 'ring-emerald-500', 'ring-offset-1');
            setTimeout(() => btn.classList.remove('ring-2', 'ring-emerald-500', 'ring-offset-1'), 700);
        }

        const toggleBtn = document.getElementById('togglePassword');
        const passInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        toggleBtn.addEventListener('click', () => {
            const isHidden = passInput.type === 'password';
            passInput.type = isHidden ? 'text' : 'password';
            eyeIcon.innerHTML = isHidden
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        });
    </script>
    @endpush
@endsection
