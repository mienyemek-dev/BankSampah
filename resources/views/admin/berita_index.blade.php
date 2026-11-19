<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita & Edukasi - Bank Sampah Bumi Sai Wawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'berita'])

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen">
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Manajemen Berita & Edukasi Warga</h1>
                <p class="text-xs text-slate-500">Publikasikan panduan pilah sampah, kegiatan bank sampah, dan artikel lingkungan</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#berita" target="_blank"
                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Lihat Web Publik
                </a>
                <a href="{{ route('admin.berita.create') }}"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tulis Artikel Baru
                </a>
            </div>
        </header>

        <main class="p-6 flex-1 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <!-- Daftar Artikel -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Semua Artikel Edukasi</h3>
                        <p class="text-xs text-slate-400">Total: {{ $beritaList->total() }} artikel tercatat</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 font-semibold">
                            <tr>
                                <th class="p-3.5">Judul & Ringkasan</th>
                                <th class="p-3.5">Kategori</th>
                                <th class="p-3.5">Penulis</th>
                                <th class="p-3.5 text-center">Dibaca</th>
                                <th class="p-3.5 text-center">Status</th>
                                <th class="p-3.5 text-center">Tanggal</th>
                                <th class="p-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($beritaList as $item)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-3.5 max-w-sm">
                                        <p class="font-bold text-slate-800 text-sm line-clamp-1">{{ $item->judul }}</p>
                                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">{{ $item->ringkasan }}</p>
                                    </td>
                                    <td class="p-3.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                            {{ $item->kategori === 'edukasi' ? 'bg-emerald-100 text-emerald-800' : ($item->kategori === 'kegiatan' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="p-3.5 font-medium text-slate-700">
                                        {{ $item->penulis->nama_lengkap ?? 'Admin' }}
                                    </td>
                                    <td class="p-3.5 text-center font-semibold text-slate-600">
                                        👁️ {{ number_format($item->dilihat) }}
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if ($item->is_published)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                ● Terbit
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600">
                                                ○ Draf
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center text-slate-500 text-[11px]">
                                        {{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            @if($item->is_published)
                                                <a href="{{ route('artikel.show', $item->slug) }}" target="_blank"
                                                    class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition" title="Lihat Artikel">
                                                    👁️
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.berita.edit', $item->id_berita) }}"
                                                class="px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold border border-amber-200 transition">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('admin.berita.destroy', $item->id_berita) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold border border-rose-200 transition">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-400">
                                        <p class="text-3xl mb-2">📰</p>
                                        <p class="font-medium">Belum ada artikel edukasi yang ditulis.</p>
                                        <a href="{{ route('admin.berita.create') }}" class="inline-block mt-3 text-xs text-emerald-600 font-bold hover:underline">
                                            + Tulis Artikel Pertama Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $beritaList->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>

