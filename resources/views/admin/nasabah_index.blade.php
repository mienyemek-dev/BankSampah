<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Nasabah - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'nasabah'])

    <main class="flex-1 overflow-y-auto">
        {{-- Header Topbar --}}
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <span>👥</span> Manajemen & Verifikasi Data Nasabah
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola verifikasi pendaftaran akun warga, pantau saldo tabungan, dan keaktifan nasabah</p>
            </div>
            <div class="relative w-64">
                <input type="text" id="searchNasabah" placeholder="Cari nama atau email..."
                    class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
            </div>
        </div>

        <div class="p-8 max-w-7xl">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6 shadow-sm">
                    <span>✅</span><span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-2 mb-6 shadow-sm">
                    <span>⚠️</span><span class="font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Alert Jika Ada Nasabah Pending --}}
            @if ($totalPending > 0)
                <div class="bg-amber-50 border border-amber-300 rounded-2xl p-4 mb-6 shadow-sm flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl animate-bounce">⏳</span>
                        <div>
                            <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider">Perhatian: Ada {{ $totalPending }} Pendaftaran Baru Menunggu Verifikasi</h3>
                            <p class="text-xs text-amber-700 mt-0.5">Akun nasabah yang berstatus pending belum dapat login sebelum disetujui oleh admin.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.nasabah', ['status' => 'pending']) }}" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow transition whitespace-nowrap">
                        Lihat Antrean Pending →
                    </a>
                </div>
            @endif

            {{-- 4 Kartu KPI & Filter Status --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('admin.nasabah') }}" 
                   class="p-4 rounded-2xl border transition shadow-sm {{ empty($status) ? 'bg-emerald-600 text-white border-emerald-600 shadow-emerald-700/20' : 'bg-white text-slate-800 border-slate-200 hover:bg-slate-50' }}">
                    <p class="text-[11px] font-bold uppercase tracking-wider {{ empty($status) ? 'text-emerald-100' : 'text-slate-400' }}">Semua Nasabah</p>
                    <p class="text-2xl font-black mt-1">{{ $totalNasabah }}</p>
                    <p class="text-[11px] mt-0.5 {{ empty($status) ? 'text-emerald-200 font-semibold' : 'text-slate-400' }}">Terdaftar di sistem</p>
                </a>

                <a href="{{ route('admin.nasabah', ['status' => 'pending']) }}" 
                   class="p-4 rounded-2xl border transition shadow-sm {{ ($status === 'pending') ? 'bg-amber-500 text-white border-amber-500 shadow-amber-600/20' : 'bg-white text-slate-800 border-slate-200 hover:bg-slate-50' }}">
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-bold uppercase tracking-wider {{ ($status === 'pending') ? 'text-amber-100' : 'text-slate-400' }}">Menunggu Verifikasi</p>
                        @if ($totalPending > 0)
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        @endif
                    </div>
                    <p class="text-2xl font-black mt-1">{{ $totalPending }}</p>
                    <p class="text-[11px] mt-0.5 {{ ($status === 'pending') ? 'text-amber-100 font-semibold' : 'text-amber-600 font-bold' }}">Perlu ditinjau</p>
                </a>

                <a href="{{ route('admin.nasabah', ['status' => 'aktif']) }}" 
                   class="p-4 rounded-2xl border transition shadow-sm {{ ($status === 'aktif') ? 'bg-emerald-700 text-white border-emerald-700 shadow-emerald-800/20' : 'bg-white text-slate-800 border-slate-200 hover:bg-slate-50' }}">
                    <p class="text-[11px] font-bold uppercase tracking-wider {{ ($status === 'aktif') ? 'text-emerald-100' : 'text-slate-400' }}">Nasabah Aktif</p>
                    <p class="text-2xl font-black mt-1">{{ $totalAktif }}</p>
                    <p class="text-[11px] mt-0.5 {{ ($status === 'aktif') ? 'text-emerald-200 font-semibold' : 'text-emerald-600 font-bold' }}">Bisa setor & login</p>
                </a>

                <a href="{{ route('admin.nasabah', ['status' => 'ditolak']) }}" 
                   class="p-4 rounded-2xl border transition shadow-sm {{ ($status === 'ditolak') ? 'bg-rose-600 text-white border-rose-600 shadow-rose-700/20' : 'bg-white text-slate-800 border-slate-200 hover:bg-slate-50' }}">
                    <p class="text-[11px] font-bold uppercase tracking-wider {{ ($status === 'ditolak') ? 'text-rose-100' : 'text-slate-400' }}">Pendaftaran Ditolak</p>
                    <p class="text-2xl font-black mt-1">{{ $totalDitolak }}</p>
                    <p class="text-[11px] mt-0.5 {{ ($status === 'ditolak') ? 'text-rose-100 font-semibold' : 'text-rose-600 font-bold' }}">Tidak diaktifkan</p>
                </a>
            </div>

            {{-- Tabel Data Nasabah --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">
                            Daftar Nasabah 
                            @if ($status === 'pending')
                                <span class="text-amber-600 font-semibold">(Menunggu Verifikasi)</span>
                            @elseif ($status === 'aktif')
                                <span class="text-emerald-600 font-semibold">(Aktif)</span>
                            @elseif ($status === 'ditolak')
                                <span class="text-rose-600 font-semibold">(Ditolak)</span>
                            @endif
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Menampilkan {{ $nasabahList->count() }} dari total {{ $nasabahList->total() }} nasabah</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs" id="tableNasabah">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3.5">ID & Nama Lengkap</th>
                                <th class="p-3.5">Email & No. HP</th>
                                <th class="p-3.5">Alamat / Desa</th>
                                <th class="p-3.5 text-right">Saldo Tabungan</th>
                                <th class="p-3.5 text-right">Total Sampah</th>
                                <th class="p-3.5 text-center">Status Akun</th>
                                <th class="p-3.5 text-center">Aksi Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($nasabahList as $nasabah)
                                <tr class="hover:bg-slate-50 transition nas-row">
                                    <td class="p-3.5">
                                        <span class="text-[10px] text-slate-400 font-mono">#{{ $nasabah->id_user }}</span>
                                        <p class="font-bold text-slate-800 text-sm nas-nama">{{ $nasabah->nama_lengkap }}</p>
                                        <p class="text-[10px] text-slate-400">Daftar: {{ $nasabah->created_at->format('d M Y, H:i') }}</p>
                                    </td>
                                    <td class="p-3.5">
                                        <p class="font-semibold text-slate-700 nas-email">{{ $nasabah->email }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $nasabah->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="p-3.5 text-slate-600 max-w-xs">
                                        {{ $nasabah->alamat_lengkap ?? ($nasabah->desa ?? 'Desa Banjar Rejo') }}
                                    </td>
                                    <td class="p-3.5 text-right font-extrabold text-emerald-700 text-sm">
                                        Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3.5 text-right font-bold text-slate-700">
                                        {{ number_format($nasabah->total_berat_sampah, 1) }} Kg
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if ($nasabah->status_akun === 'aktif')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                <span>●</span> Aktif
                                            </span>
                                        @elseif ($nasabah->status_akun === 'pending')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                                <span>⏳</span> Menunggu Verifikasi
                                            </span>
                                        @elseif ($nasabah->status_akun === 'ditolak')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                                <span>❌</span> Ditolak
                                            </span>
                                            @if ($nasabah->alasan_penolakan)
                                                <p class="text-[10px] text-rose-500 italic mt-0.5">"{{ $nasabah->alasan_penolakan }}"</p>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if ($nasabah->status_akun === 'pending')
                                            <div class="flex items-center justify-center gap-1.5">
                                                {{-- Form Setujui --}}
                                                <form method="POST" action="{{ route('admin.nasabah.verifikasi', $nasabah->id_user) }}" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI dan MENGAKTIFKAN akun nasabah {{ $nasabah->nama_lengkap }}?')">
                                                    @csrf
                                                    <input type="hidden" name="status_akun" value="aktif">
                                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition flex items-center gap-1">
                                                        <span>✅</span> Setujui
                                                    </button>
                                                </form>

                                                {{-- Form Tolak --}}
                                                <form method="POST" action="{{ route('admin.nasabah.verifikasi', $nasabah->id_user) }}" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK pendaftaran nasabah {{ $nasabah->nama_lengkap }}?')">
                                                    @csrf
                                                    <input type="hidden" name="status_akun" value="ditolak">
                                                    <input type="hidden" name="alasan_penolakan" value="Data identitas atau alamat tidak valid">
                                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif ($nasabah->status_akun === 'aktif')
                                            <span class="text-[11px] text-emerald-600 font-semibold flex items-center justify-center gap-1">
                                                <span>✓</span> Terverifikasi
                                            </span>
                                        @elseif ($nasabah->status_akun === 'ditolak')
                                            {{-- Form Pulihkan / Aktifkan Kembali --}}
                                            <form method="POST" action="{{ route('admin.nasabah.verifikasi', $nasabah->id_user) }}" onsubmit="return confirm('Pulihkan dan aktifkan kembali akun ini?')">
                                                @csrf
                                                <input type="hidden" name="status_akun" value="aktif">
                                                <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-emerald-800 transition">
                                                    Aktifkan Kembali
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-slate-400">
                                        <div class="text-4xl mb-2">👥</div>
                                        <p class="font-bold text-slate-600">Tidak ada data nasabah pada kategori ini</p>
                                        <p class="text-xs text-slate-400 mt-1">Coba ganti filter status atau bersihkan kata kunci pencarian</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($nasabahList->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $nasabahList->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>

    <script>
        document.getElementById('searchNasabah')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.nas-row').forEach(r => {
                const nama = r.querySelector('.nas-nama')?.textContent.toLowerCase() || '';
                const email = r.querySelector('.nas-email')?.textContent.toLowerCase() || '';
                if (nama.includes(q) || email.includes(q)) {
                    r.style.display = '';
                } else {
                    r.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>