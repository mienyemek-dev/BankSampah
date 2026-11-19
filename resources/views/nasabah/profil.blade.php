<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil & Pengaturan Akun - Bank Sampah Bumi Sai Wawai</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Plus_Jakarta_Sans'] text-slate-800 antialiased min-h-screen">

    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard.redirect') }}" class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-bold shadow-sm">
                    🌿
                </a>
                <div>
                    <h1 class="font-extrabold text-sm text-slate-900 leading-tight">Pengaturan Akun</h1>
                    <p class="text-[11px] text-emerald-700 font-semibold">{{ $user->nama_lengkap }} &bull; {{ strtoupper($user->role) }}</p>
                </div>
            </div>

            <a href="{{ route('dashboard.redirect') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        @if(session('success_password'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <span>🔐</span> {{ session('success_password') }}
            </div>
        @endif

        <!-- Card Identitas Ringkas -->
        <div class="bg-gradient-to-r from-emerald-800 to-emerald-700 rounded-2xl p-6 text-white shadow-md flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur border border-white/30 flex items-center justify-center text-3xl font-extrabold">
                    {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-extrabold">{{ $user->nama_lengkap }}</h2>
                    <p class="text-xs text-emerald-200 mt-0.5">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white border border-white/30">
                            Role: {{ strtoupper($user->role) }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-400 text-emerald-950">
                            Status: {{ strtoupper($user->status_akun ?? 'AKTIF') }}
                        </span>
                    </div>
                </div>
            </div>

            @if($user->role === 'nasabah')
            <div class="bg-white/10 backdrop-blur rounded-xl p-3 border border-white/20 text-right">
                <p class="text-[11px] text-emerald-200">Saldo Tabungan Saat Ini</p>
                <p class="text-2xl font-extrabold text-white">Rp {{ number_format($user->saldo ?? 0, 0, ',', '.') }}</p>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Form Data Diri & Domisili -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-2 pb-4 border-b border-slate-100 mb-5">
                    <span class="text-xl">👤</span>
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Data Diri & Alamat Domisili</h3>
                        <p class="text-xs text-slate-400">Informasi ini digunakan untuk penjemputan bentor dan pencairan saldo</p>
                    </div>
                </div>

                @if ($errors->any() && !$errors->has('password_saat_ini') && !$errors->has('password_baru'))
                    <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs mb-4">
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profil.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_lengkap" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Alamat Email
                            </label>
                            <input type="email" id="email" value="{{ $user->email }}" disabled
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 text-sm cursor-not-allowed outline-none" title="Email akun tidak dapat diubah">
                        </div>
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nomor WhatsApp / HP Aktif
                        </label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <label for="rt" class="block text-xs font-bold text-slate-700 uppercase mb-1">RT</label>
                            <input type="text" id="rt" name="rt" value="{{ old('rt', $user->rt) }}" placeholder="01"
                                class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div>
                            <label for="rw" class="block text-xs font-bold text-slate-700 uppercase mb-1">RW</label>
                            <input type="text" id="rw" name="rw" value="{{ old('rw', $user->rw) }}" placeholder="02"
                                class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div>
                            <label for="desa" class="block text-xs font-bold text-slate-700 uppercase mb-1">Desa</label>
                            <input type="text" id="desa" name="desa" value="{{ old('desa', $user->desa ?? 'Banjar Rejo') }}"
                                class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div>
                            <label for="kecamatan" class="block text-xs font-bold text-slate-700 uppercase mb-1">Kecamatan</label>
                            <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $user->kecamatan ?? 'Batanghari') }}"
                                class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="alamat_lengkap" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Alamat Lengkap (Patokan / Nomor Rumah)
                        </label>
                        <textarea id="alamat_lengkap" name="alamat_lengkap" rows="2"
                            placeholder="Contoh: Jl. Poros Banjar Rejo No. 12, samping masjid Baiturrahim..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-bold text-slate-700 uppercase mb-3">Rekening Bank / E-Wallet Default (Opsional)</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label for="nama_bank" class="block text-[11px] text-slate-500 mb-1">Bank / E-Wallet</label>
                                <input type="text" id="nama_bank" name="nama_bank" value="{{ old('nama_bank', $user->nama_bank) }}" placeholder="BRI / DANA / BCA"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label for="nomor_rekening" class="block text-[11px] text-slate-500 mb-1">Nomor Rekening / No HP</label>
                                <input type="text" id="nomor_rekening" name="nomor_rekening" value="{{ old('nomor_rekening', $user->nomor_rekening) }}" placeholder="0123456789"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label for="atas_nama_rekening" class="block text-[11px] text-slate-500 mb-1">Atas Nama Rekening</label>
                                <input type="text" id="atas_nama_rekening" name="atas_nama_rekening" value="{{ old('atas_nama_rekening', $user->atas_nama_rekening) }}" placeholder="Sesuai buku tabungan"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                            <span>💾</span> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form Ganti Password -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-fit">
                <div class="flex items-center gap-2 pb-4 border-b border-slate-100 mb-5">
                    <span class="text-xl">🔐</span>
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Keamanan & Sandi</h3>
                        <p class="text-xs text-slate-400">Ubah kata sandi akun Anda secara berkala</p>
                    </div>
                </div>

                @if ($errors->has('password_saat_ini') || $errors->has('password_baru'))
                    <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs mb-4">
                        <ul class="list-disc pl-4 space-y-0.5">
                            @error('password_saat_ini') <li>{{ $message }}</li> @enderror
                            @error('password_baru') <li>{{ $message }}</li> @enderror
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profil.password') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="password_saat_ini" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" id="password_saat_ini" name="password_saat_ini" required
                            placeholder="••••••••"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label for="password_baru" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Kata Sandi Baru <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" id="password_baru" name="password_baru" required
                            placeholder="Minimal 8 karakter"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label for="password_baru_confirmation" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Ulangi Kata Sandi Baru <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" required
                            placeholder="Ketik ulang kata sandi baru"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5">
                            <span>🔑</span> Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>
</html>

