<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transit Limbah RS - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'transit'])

    <main class="flex-1 overflow-y-auto">
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">🏥 Manifes Transit Limbah Rumah Sakit</h1>
                <p class="text-xs text-slate-500 mt-0.5">Pencatatan manifes limbah medis sesuai regulasi B3 — depo transit resmi</p>
            </div>
            <span class="text-xs bg-rose-100 text-rose-800 font-bold px-3 py-1.5 rounded-full border border-rose-200">
                🏥 Logistik B2B Transit Medis
            </span>
        </div>

        <div class="p-8">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 mb-6">
                    <span>✅</span><span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Form Manifes --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-rose-100 flex items-center justify-center text-lg">📋</div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Catat Manifes Limbah</h2>
                            <p class="text-xs text-slate-500">Transit masuk ke depo Bank Sampah</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.transit_limbah.store') }}" class="space-y-3.5">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. Surat Jalan / Manifes</label>
                            <input type="text" name="nomor_manifest" placeholder="MNF-2026-001" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Rumah Sakit Asal</label>
                            <input type="text" name="rumah_sakit_asal" placeholder="RSUD / RS Mitra Lampung Timur" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pengelola B3 Tujuan</label>
                            <input type="text" name="pengelola_utama_tujuan" placeholder="PT Pengolah Limbah Medis B3" required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Limbah</label>
                            <input type="text" name="jenis_limbah" placeholder="Medis padat steril, jerigen infus..." required
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Berat (Kg)</label>
                                <input type="number" step="0.5" min="0.5" name="berat_kg" value="10" required
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tgl. Masuk Depo</label>
                                <input type="date" name="waktu_masuk_depo" value="{{ date('Y-m-d') }}" required
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">
                            💾 Simpan Manifes Transit
                        </button>
                    </form>
                </div>

                {{-- Daftar Manifes --}}
                <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800">Daftar Manifes Transit Tercatat</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pengawasan ketat alur limbah medis yang singgah di depo</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                                <tr>
                                    <th class="p-3">No. Manifes</th>
                                    <th class="p-3">Asal RS & Vendor</th>
                                    <th class="p-3">Jenis & Berat</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($transitList as $tr)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="p-3 font-mono font-bold text-slate-800">
                                            {{ $tr->nomor_manifest }}
                                            <p class="text-[10px] text-slate-400 font-sans">{{ $tr->waktu_masuk_depo->format('d M Y') }}</p>
                                        </td>
                                        <td class="p-3">
                                            <p class="font-bold text-slate-800">{{ $tr->rumah_sakit_asal }}</p>
                                            <p class="text-[11px] text-slate-400">→ {{ $tr->pengelola_utama_tujuan }}</p>
                                        </td>
                                        <td class="p-3">
                                            <p class="font-semibold text-slate-700">{{ $tr->jenis_limbah }}</p>
                                            <p class="text-[11px] text-slate-500 font-bold">{{ number_format($tr->berat_kg, 1) }} Kg</p>
                                        </td>
                                        <td class="p-3">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                📦 {{ ucfirst(str_replace('_', ' ', $tr->status_transit)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400">
                                            <div class="text-3xl mb-2">🏥</div>
                                            <p class="font-semibold">Belum ada manifes transit limbah RS tercatat</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $transitList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
