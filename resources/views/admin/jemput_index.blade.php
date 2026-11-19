<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penjemputan Bentor - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'jemput'])

    <main class="flex-1 overflow-y-auto">
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">🛺 Manajemen Armada Bentor Jemput Sampah</h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola penjadwalan & status penjemputan sampah ke rumah warga</p>
            </div>
            <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-3 py-1.5 rounded-full border border-emerald-200">
                🛵 Armada Motor Roda 3
            </span>
        </div>

        <div class="p-8">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6">
                    <span>✅</span><span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800">Daftar Permohonan Jemput</h3>
                    <div class="relative">
                        <input type="text" id="searchJemput" placeholder="Cari nama / kode..."
                            class="pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none w-48">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3">Kode & Tanggal</th>
                                <th class="p-3">Nasabah & Kontak</th>
                                <th class="p-3">Alamat & Patokan</th>
                                <th class="p-3">Estimasi</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($jemputList as $j)
                                <tr class="hover:bg-slate-50 transition jemput-row">
                                    <td class="p-3">
                                        <span class="font-bold font-mono text-slate-800">{{ $j->kode_penjemputan }}</span>
                                        <p class="text-[11px] text-slate-400">{{ $j->tanggal_rencana_jemput->format('d M Y') }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $j->waktu_preferensi }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="font-bold text-slate-800">{{ $j->nasabah->nama_lengkap ?? 'Nasabah' }}</p>
                                        <p class="text-[11px] text-slate-500">📱 {{ $j->nasabah->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="p-3 max-w-xs">
                                        <p class="text-slate-700 font-medium">{{ $j->alamat_jemput }}</p>
                                        @if ($j->patokan_lokasi)
                                            <p class="text-[11px] text-slate-400 italic">📍 {{ $j->patokan_lokasi }}</p>
                                        @endif
                                    </td>
                                    <td class="p-3 font-bold text-slate-700">
                                        ~{{ number_format($j->estimasi_berat, 1) }} Kg
                                    </td>
                                    <td class="p-3">
                                        @php
                                            $statusMap = [
                                                'menunggu'       => ['⏳ Menunggu',    'bg-amber-100 text-amber-800'],
                                                'dijadwalkan'    => ['📅 Dijadwalkan', 'bg-blue-100 text-blue-800'],
                                                'sedang_dijemput'=> ['🛵 Menuju',      'bg-indigo-100 text-indigo-800'],
                                                'selesai'        => ['✅ Selesai',     'bg-emerald-100 text-emerald-800'],
                                                'dibatalkan'     => ['❌ Batal',       'bg-rose-100 text-rose-800'],
                                            ];
                                            [$statusLabel, $statusClass] = $statusMap[$j->status_jemput] ?? ['❓', 'bg-slate-100 text-slate-700'];
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <form method="POST" action="{{ route('admin.jemput.update', $j->id_permohonan_jemput) }}" class="inline-flex gap-1.5">
                                            @csrf
                                            <select name="status_jemput" class="px-2 py-1.5 rounded-lg border border-slate-200 text-[11px] outline-none focus:ring-1 focus:ring-emerald-500">
                                                <option value="dijadwalkan"    {{ $j->status_jemput == 'dijadwalkan'    ? 'selected' : '' }}>Jadwalkan</option>
                                                <option value="sedang_dijemput"{{ $j->status_jemput == 'sedang_dijemput'? 'selected' : '' }}>Sedang Jemput</option>
                                                <option value="selesai"        {{ $j->status_jemput == 'selesai'        ? 'selected' : '' }}>Selesai</option>
                                                <option value="dibatalkan"     {{ $j->status_jemput == 'dibatalkan'     ? 'selected' : '' }}>Batalkan</option>
                                            </select>
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[11px] font-bold transition shadow-sm">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">
                                        <div class="text-3xl mb-2">🛺</div>
                                        <p class="font-semibold">Belum ada permohonan penjemputan sampah</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $jemputList->links() }}
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('searchJemput')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.jemput-row').forEach(r => {
                r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
