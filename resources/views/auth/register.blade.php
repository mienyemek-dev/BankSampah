@extends('layouts.auth')

@section('title', 'Daftar Nasabah Baru')

@section('content')
    {{-- Kembali ke Landing Page --}}
    <div class="mb-5">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-emerald-700 hover:text-emerald-800 font-semibold transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Halaman Utama
        </a>
    </div>
    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Daftar Nasabah Baru</h2>
        <p class="text-xs text-slate-500 mt-1">Hanya butuh nama dan kata sandi untuk mulai menabung sampah!</p>
    </div>

    <form method="POST" action="{{ route('register.post') }}" class="space-y-3.5">
        @csrf

        <!-- Nama Lengkap / Username -->
        <div>
            <label for="nama_lengkap" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Nama Lengkap / Nama Pengguna <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required autofocus
                    placeholder="Contoh: Budi Santoso"
                    class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('nama_lengkap') border-rose-400 ring-rose-200 @enderror">
            </div>
            @error('nama_lengkap')
                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Alamat Email <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    placeholder="budi@example.com"
                    class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('email') border-rose-400 ring-rose-200 @enderror">
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- No HP (Opsional) -->
        <div>
            <label for="no_hp" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                No. WhatsApp / HP <span class="text-slate-400 font-normal lowercase">(opsional)</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                    placeholder="08123456789"
                    class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Kata Sandi <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input type="password" id="password" name="password" required
                    placeholder="Minimal 6 karakter"
                    class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('password') border-rose-400 ring-rose-200 @enderror">
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Ulangi Kata Sandi <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    placeholder="Ulangi kata sandi"
                    class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full mt-3 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold text-sm rounded-xl shadow-lg shadow-emerald-600/30 transition duration-150 flex items-center justify-center gap-2">
            <span>Daftar & Mulai Menabung</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>

    <!-- Login Link -->
    <div class="mt-5 pt-4 border-t border-slate-100 text-center">
        <p class="text-xs text-slate-600">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:text-emerald-800 hover:underline">
                Masuk di Sini
            </a>
        </p>
    </div>
@endsection

