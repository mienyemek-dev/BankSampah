<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minta Jemput Sampah (Armada Bentor) - Bank Sampah</title>
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
                <h1 class="font-bold text-base">Permohonan Penjemputan Sampah</h1>
            </div>
            <div class="text-right">
                <span class="text-xs bg-emerald-700 px-2.5 py-1 rounded-md text-emerald-100">🛵 Armada Bentor Banjar Rejo</span>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8 flex-1 w-full">
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Form Pengajuan Jemput -->
            <div class="md:col-span-1 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <h2 class="text-base font-bold text-slate-800 mb-1">Form Jadwal Penjemputan</h2>
                <p class="text-xs text-slate-500 mb-5">Petugas armada Bentor akan datang menimbang sampah langsung di rumah Anda.</p>

                <form method="POST" action="{{ route('nasabah.jemput_sampah.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Tanggal Rencana Jemput</label>
                        <input type="date" name="tanggal_rencana_jemput" min="{{ date('Y-m-d') }}" required value="{{ old('tanggal_rencana_jemput', date('Y-m-d', strtotime('+1 day'))) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Waktu Pilihan</label>
                        <select name="waktu_preferensi" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="Pagi (08:30 - 11:30 WIB)">Pagi (08:30 - 11:30 WIB)</option>
                            <option value="Siang (13:30 - 16:00 WIB)">Siang (13:30 - 16:00 WIB)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Estimasi Berat Sampah (Kg)</label>
                        <input type="number" step="0.5" min="5" name="estimasi_berat" placeholder="Min. 5 Kg" required value="{{ old('estimasi_berat', 5) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        <p class="text-[11px] text-slate-400 mt-1">Minimal berat jemputan bentor adalah 5 Kg.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Penjemputan</label>
                        <textarea name="alamat_jemput" rows="2" required placeholder="Jalan, RT/RW, Dusun..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('alamat_jemput', Auth::user()->alamat_lengkap) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Patokan Lokasi / Catatan</label>
                        <input type="text" name="patokan_lokasi" placeholder="Contoh: Depan masjid, rumah pagar hitam" value="{{ old('patokan_lokasi') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/30 transition">
                        Pesan Penjemputan Bentor
                    </button>
                </form>
            </div>

            <!-- Tabel Riwayat Penjemputan -->
            <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <h3 class="font-bold text-slate-800 text-base mb-1">Daftar Jadwal & Status Penjemputan</h3>
                <p class="text-xs text-slate-500 mb-4">Status penjemputan sampah dari kediaman Anda.</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100">
                            <tr>
                                <th class="p-3">Kode Jemput</th>
                                <th class="p-3">Rencana & Waktu</th>
                                <th class="p-3">Estimasi</th>
                                <th class="p-3">Status Armada</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($riwayatJemput as $j)
                                <tr class="hover:bg-slate-50">
                                    <td class="p-3">
                                        <p class="font-bold text-slate-800">{{ $j->kode_penjemputan }}</p>
                                        <p class="text-[11px] text-slate-400 line-clamp-1">{{ $j->alamat_jemput }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="font-semibold text-slate-700">{{ $j->tanggal_rencana_jemput->format('d M Y') }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $j->waktu_preferensi }}</p>
                                    </td>
                                    <td class="p-3 font-bold text-slate-700">
                                        {{ number_format($j->estimasi_berat, 1) }} Kg
                                    </td>
                                    <td class="p-3">
                                        @if ($j->status_jemput === 'menunggu')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                ⏳ Menunggu Penjadwalan
                                            </span>
                                        @elseif ($j->status_jemput === 'dijadwalkan')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                                📅 Sudah Dijadwalkan
                                            </span>
                                        @elseif ($j->status_jemput === 'sedang_dijemput')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 animate-pulse">
                                                🛵 Bentor Sedang Menuju Lokasi
                                            </span>
                                        @elseif ($j->status_jemput === 'selesai')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                ✅ Selesai Ditimbang
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">
                                                {{ ucfirst($j->status_jemput) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-slate-400">
                                        Belum ada riwayat permohonan penjemputan sampah.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $riwayatJemput->links() }}
                </div>
            </div>
        </div>
    </main>

    {{-- Maskot Interaktif Si Wawai --}}
    @include('components.mascot-siwawai')
</body>
</html>

