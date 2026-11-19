<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Harga Sampah - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'harga'])

    <main class="flex-1 overflow-y-auto">
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">🏷️ Master Komoditas & Harga Beli Sampah</h1>
                <p class="text-xs text-slate-500 mt-0.5">Edit harga beli nasabah & estimasi jual pabrik — perubahan berlaku untuk transaksi baru</p>
            </div>
            <span class="text-xs bg-slate-100 px-3 py-1.5 rounded-full text-slate-600 font-semibold border border-slate-200">
                Terkunci di Snapshot Transaksi
            </span>
        </div>

        <div class="p-8">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6">
                    <span>✅</span><span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800">Daftar Komoditas Sampah</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Klik "Simpan" per baris untuk memperbarui harga</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3">Nama Komoditas</th>
                                <th class="p-3">Kategori</th>
                                <th class="p-3">Satuan</th>
                                <th class="p-3">Harga Beli Nasabah (Rp)</th>
                                <th class="p-3">Est. Jual Pabrik (Rp)</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($sampahList as $s)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-3">
                                        <p class="font-bold text-slate-800">{{ $s->nama_sampah }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $s->deskripsi }}</p>
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-bold border border-emerald-200">
                                            {{ $s->kategori->nama_kategori ?? 'Sampah' }}
                                        </span>
                                    </td>
                                    <td class="p-3 font-semibold text-slate-700 uppercase">
                                        {{ $s->satuan }}
                                    </td>
                                    <form method="POST" action="{{ route('admin.harga_sampah.update', $s->id_sampah) }}">
                                        @csrf
                                        <td class="p-3">
                                            <input type="number" name="harga_beli_nasabah" value="{{ (int)$s->harga_beli_nasabah }}" step="any" min="0"
                                                class="w-28 px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-emerald-700 outline-none focus:ring-2 focus:ring-emerald-500">
                                        </td>
                                        <td class="p-3">
                                            <input type="number" name="harga_jual_pengepul" value="{{ (int)$s->harga_jual_pengepul }}" step="any" min="0"
                                                class="w-28 px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-emerald-500">
                                        </td>
                                        <td class="p-3">
                                            <select name="is_aktif" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-[11px] outline-none focus:ring-1 focus:ring-emerald-500">
                                                <option value="1" {{ $s->is_aktif ? 'selected' : '' }}>✅ Aktif</option>
                                                <option value="0" {{ !$s->is_aktif ? 'selected' : '' }}>⏸ Nonaktif</option>
                                            </select>
                                        </td>
                                        <td class="p-3 text-right">
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                                💾 Simpan
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $sampahList->links() }}
                </div>
            </div>
        </div>
    </main>
</body>
</html>
