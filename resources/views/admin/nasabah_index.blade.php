<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Nasabah - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'nasabah'])

    <main class="flex-1 overflow-y-auto">
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">👥 Manajemen Data Nasabah</h1>
                <p class="text-xs text-slate-500 mt-0.5">Total <span class="font-bold text-emerald-700">{{ $nasabahList->total() }}</span> nasabah terdaftar di Bank Sampah Bumi Sai Wawai</p>
            </div>
            <div class="relative">
                <input type="text" id="searchNasabah" placeholder="Cari nama / email..."
                    class="pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none w-52">
                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
            </div>
        </div>

        <div class="p-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs" id="tableNasabah">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3">ID & Nama Lengkap</th>
                                <th class="p-3">Email & Kontak</th>
                                <th class="p-3">Alamat / Wilayah</th>
                                <th class="p-3 text-right">Saldo Tabungan</th>
                                <th class="p-3 text-right">Total Sampah</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($nasabahList as $nasabah)
                                <tr class="hover:bg-slate-50 transition nas-row">
                                    <td class="p-3">
                                        <span class="text-[10px] text-slate-400 font-mono">#{{ $nasabah->id_user }}</span>
                                        <p class="font-bold text-slate-800 text-sm">{{ $nasabah->nama_lengkap }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="font-semibold text-slate-700">{{ $nasabah->email }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $nasabah->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="p-3 text-slate-600 max-w-xs">
                                        {{ $nasabah->alamat_lengkap ?? ($nasabah->desa ?? 'Banjar Rejo') }}
                                    </td>
                                    <td class="p-3 text-right font-extrabold text-emerald-700 text-sm">
                                        Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3 text-right font-bold text-slate-700">
                                        {{ number_format($nasabah->total_berat_sampah, 1) }} Kg
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            ● Aktif
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">
                                        <div class="text-3xl mb-2">👥</div>
                                        <p class="font-semibold">Belum ada nasabah terdaftar</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $nasabahList->links() }}
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('searchNasabah')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.nas-row').forEach(r => {
                r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
