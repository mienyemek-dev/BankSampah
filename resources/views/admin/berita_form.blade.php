<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Artikel' : 'Tulis Artikel Baru' }} - Bank Sampah Bumi Sai Wawai</title>
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
                <h1 class="text-lg font-bold text-slate-800">{{ $isEdit ? 'Edit Artikel Edukasi' : 'Tulis Artikel Edukasi Baru' }}</h1>
                <p class="text-xs text-slate-500">Artikel yang diterbitkan akan langsung tampil di beranda depan untuk masyarakat</p>
            </div>
            <a href="{{ route('admin.berita') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                ← Kembali ke Daftar Artikel
            </a>
        </header>

        <main class="p-6 flex-1 max-w-4xl">
            @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs mb-6">
                    <p class="font-bold mb-1">Terdapat kesalahan pengisian formulir:</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <form action="{{ $isEdit ? route('admin.berita.update', $berita->id_berita) : route('admin.berita.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Judul Artikel <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required
                            placeholder="Contoh: Panduan Praktis Memilah Sampah Plastik Rumah Tangga"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <select id="kategori" name="kategori" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="edukasi" {{ old('kategori', $berita->kategori) === 'edukasi' ? 'selected' : '' }}>🌱 Edukasi & Tips Lingkungan</option>
                                <option value="kegiatan" {{ old('kategori', $berita->kategori) === 'kegiatan' ? 'selected' : '' }}>📸 Kegiatan & Aksi Bank Sampah</option>
                                <option value="pengumuman" {{ old('kategori', $berita->kategori) === 'pengumuman' ? 'selected' : '' }}>📢 Pengumuman & Jadwal</option>
                            </select>
                        </div>

                        <!-- Status Publikasi -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">
                                Status Publikasi
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer mt-1">
                                <input type="checkbox" name="is_published" value="1"
                                    {{ old('is_published', $berita->is_published ?? true) ? 'checked' : '' }}
                                    class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500 border-slate-300">
                                <span class="text-sm font-semibold text-slate-700">Terbitkan langsung ke halaman web publik</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="ringkasan" class="text-xs font-bold text-slate-700 uppercase">
                                Ringkasan Singkat (Lead / Teaser)
                            </label>
                            <span class="text-[11px] text-slate-400">Opsional (akan terisi otomatis jika dikosongkan)</span>
                        </div>
                        <textarea id="ringkasan" name="ringkasan" rows="2"
                            placeholder="Ringkasan 1-2 kalimat pengantar yang menarik pembaca..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                    </div>

                    <!-- Konten Lengkap -->
                    <div>
                        <label for="konten" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Konten / Isi Lengkap Artikel <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="konten" name="konten" rows="12" required
                            placeholder="Tuliskan isi artikel edukasi di sini secara lengkap. Anda dapat menggunakan baris baru dan paragraf bebas..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none leading-relaxed">{{ old('konten', $berita->konten) }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('admin.berita') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                            <span>💾</span>
                            <span>{{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Artikel Sekarang' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

