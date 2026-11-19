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
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}</script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    @include('components.admin-sidebar', ['active' => 'jemput'])

    <main class="flex-1 overflow-y-auto">
        {{-- Top Header --}}
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <span>🛺</span> Manajemen Armada Bentor Jemput Sampah
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Penjadwalan, penugasan pengemudi motor bentor roda 3, dan pemantauan penjemputan sampah warga</p>
            </div>
            <div class="relative w-64">
                <input type="text" id="searchJemput" placeholder="Cari nama, kode, atau alamat..."
                    class="w-full pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
            </div>
        </div>

        <div class="p-8 max-w-7xl space-y-6">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-sm">
                    <span>✅</span><span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 4 Kartu KPI Status Jemput --}}
            @php
                $cntMenunggu   = $jemputList->where('status_jemput', 'menunggu')->count();
                $cntJadwal     = $jemputList->where('status_jemput', 'dijadwalkan')->count();
                $cntJalan      = $jemputList->where('status_jemput', 'sedang_dijemput')->count();
                $cntSelesai    = $jemputList->where('status_jemput', 'selesai')->count();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-xl flex-shrink-0">⏳</div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase">Menunggu</p>
                        <p class="text-2xl font-black text-amber-700 mt-0.5">{{ $cntMenunggu }}</p>
                        <p class="text-[10px] text-amber-600 font-semibold">Perlu dijadwalkan</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-xl flex-shrink-0">📅</div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase">Dijadwalkan</p>
                        <p class="text-2xl font-black text-blue-700 mt-0.5">{{ $cntJadwal }}</p>
                        <p class="text-[10px] text-blue-600 font-semibold">Driver ditugaskan</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-xl flex-shrink-0">🛵</div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase">Sedang Jemput</p>
                        <p class="text-2xl font-black text-indigo-700 mt-0.5">{{ $cntJalan }}</p>
                        <p class="text-[10px] text-indigo-600 font-semibold">Armada di jalan</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-xl flex-shrink-0">✅</div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase">Selesai</p>
                        <p class="text-2xl font-black text-emerald-700 mt-0.5">{{ $cntSelesai }}</p>
                        <p class="text-[10px] text-emerald-600 font-semibold">Sampah tiba di depo</p>
                    </div>
                </div>
            </div>

            {{-- Tabel Permohonan Jemput --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Daftar Permohonan Penjemputan Sampah</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tugaskan pengemudi bentor dan pantau rute jemputan sampah rumah tangga</p>
                    </div>
                    <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1 rounded-lg font-medium">
                        {{ $jemputList->total() }} Total Permohonan
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3.5">Kode & Rencana Waktu</th>
                                <th class="p-3.5">Nasabah & Kontak</th>
                                <th class="p-3.5">Alamat Penjemputan</th>
                                <th class="p-3.5 text-center">Estimasi Berat</th>
                                <th class="p-3.5">Driver / Petugas Bentor</th>
                                <th class="p-3.5 text-center">Status</th>
                                <th class="p-3.5 text-center">Aksi / Penugasan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($jemputList as $j)
                                <tr class="hover:bg-slate-50 transition jemput-row">
                                    <td class="p-3.5">
                                        <span class="font-bold font-mono text-blue-700">{{ $j->kode_penjemputan }}</span>
                                        <p class="text-[11px] text-slate-600 font-semibold mt-0.5">📅 {{ $j->tanggal_rencana_jemput->format('d M Y') }}</p>
                                        <p class="text-[10px] text-slate-400">⏰ {{ $j->waktu_preferensi }}</p>
                                    </td>
                                    <td class="p-3.5">
                                        <p class="font-bold text-slate-800 jemput-nama">{{ $j->nasabah->nama_lengkap ?? 'Nasabah' }}</p>
                                        <p class="text-[11px] text-slate-500">📱 {{ $j->nasabah->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="p-3.5 max-w-xs">
                                        <p class="text-slate-700 font-medium jemput-alamat">{{ $j->alamat_jemput }}</p>
                                        @if ($j->patokan_lokasi)
                                            <p class="text-[11px] text-slate-400 italic mt-0.5">📍 Patokan: {{ $j->patokan_lokasi }}</p>
                                        @endif
                                        @if ($j->catatan_nasabah)
                                            <p class="text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md mt-1 inline-block">
                                                💬 "{{ $j->catatan_nasabah }}"
                                            </p>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center font-bold text-slate-700 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-800 text-[11px]">
                                            ~{{ number_format($j->estimasi_berat, 1) }} Kg
                                        </span>
                                    </td>
                                    <td class="p-3.5">
                                        @if ($j->petugas)
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                                    🛵
                                                </span>
                                                <div>
                                                    <p class="font-bold text-slate-800 text-xs">{{ $j->petugas->nama_lengkap }}</p>
                                                    <p class="text-[10px] text-emerald-600 font-semibold">Driver Ditugaskan</p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
                                                <span>⚪</span> Belum Ditugaskan
                                            </span>
                                        @endif

                                        @if ($j->catatan_petugas)
                                            <p class="text-[10px] text-slate-500 italic mt-1">
                                                📝 {{ $j->catatan_petugas }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center whitespace-nowrap">
                                        @php
                                            $statusMap = [
                                                'menunggu'       => ['⏳ Menunggu',    'bg-amber-100 text-amber-800 border-amber-300'],
                                                'dijadwalkan'    => ['📅 Dijadwalkan', 'bg-blue-100 text-blue-800 border-blue-300'],
                                                'sedang_dijemput'=> ['🛵 Sedang Jemput', 'bg-indigo-100 text-indigo-800 border-indigo-300'],
                                                'selesai'        => ['✅ Selesai',     'bg-emerald-100 text-emerald-800 border-emerald-300'],
                                                'dibatalkan'     => ['❌ Dibatalkan',   'bg-rose-100 text-rose-800 border-rose-300'],
                                            ];
                                            [$statusLabel, $statusClass] = $statusMap[$j->status_jemput] ?? ['❓', 'bg-slate-100 text-slate-700 border-slate-200'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-center whitespace-nowrap">
                                        <button type="button"
                                            onclick="openTugaskanModal({{ $j->id_permohonan_jemput }}, '{{ $j->kode_penjemputan }}', '{{ addslashes($j->nasabah->nama_lengkap ?? 'Nasabah') }}', '{{ addslashes($j->alamat_jemput) }}', '{{ $j->status_jemput }}', '{{ $j->id_petugas ?? '' }}', '{{ addslashes($j->catatan_petugas ?? '') }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm flex items-center justify-center gap-1.5 mx-auto {{ $j->status_jemput === 'selesai' ? 'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-700/20' }}">
                                            <span>🛵</span>
                                            <span>{{ $j->petugas ? 'Ubah Driver / Status' : 'Tugaskan Driver' }}</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-slate-400">
                                        <div class="text-4xl mb-2">🛺</div>
                                        <p class="font-bold text-slate-600">Belum ada permohonan penjemputan sampah</p>
                                        <p class="text-xs text-slate-400 mt-1">Permohonan penjemputan bentor dari warga akan muncul di tabel ini</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($jemputList->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $jemputList->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>

    {{-- ============================================================ --}}
    {{-- MODAL PENUGASAN DRIVER BENTOR & STATUS JEMPUT                --}}
    {{-- ============================================================ --}}
    <div id="modalTugaskan" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95">
            
            {{-- Modal Header --}}
            <div class="p-6 bg-gradient-to-r from-emerald-800 to-teal-800 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🛵</span>
                    <div>
                        <h3 class="text-base font-bold">Penugasan Driver & Status Armada</h3>
                        <p class="text-xs text-emerald-200" id="mKodeJemput">JMP-XXXXXX</p>
                    </div>
                </div>
                <button type="button" onclick="closeTugaskanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                    ✕
                </button>
            </div>

            <form id="formTugaskan" method="POST" action="" class="p-6 space-y-4">
                @csrf

                {{-- Detail Penjemputan --}}
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 space-y-1.5 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-semibold">Nama Nasabah:</span>
                        <span class="font-bold text-slate-800" id="mNamaNasabah">-</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-slate-500 font-semibold flex-shrink-0">Alamat Jemput:</span>
                        <span class="font-medium text-slate-700 text-right max-w-xs" id="mAlamatJemput">-</span>
                    </div>
                </div>

                {{-- Pilih Driver Bentor --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Pilih Staf Pengemudi / Driver Bentor <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_petugas" id="mSelectPetugas" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        <option value="">-- Pilih Staf Pengemudi --</option>
                        @foreach ($petugasList as $p)
                            <option value="{{ $p->id_user }}">
                                🛵 {{ $p->nama_lengkap }} ({{ strtoupper(str_replace('_', ' ', $p->role)) }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">
                        Pilih staf yang bertanggung jawab membawa armada bentor ke lokasi nasabah.
                    </p>
                </div>

                {{-- Pilih Status Penjemputan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Update Status Armada Bentor <span class="text-rose-500">*</span>
                    </label>
                    <select name="status_jemput" id="mSelectStatus" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        <option value="dijadwalkan">📅 Dijadwalkan (Driver sudah ditetapkan)</option>
                        <option value="sedang_dijemput">🛵 Sedang Dijemput (Armada bentor sedang meluncur ke lokasi)</option>
                        <option value="selesai">✅ Selesai (Sampah sudah dijemput & tiba di depo)</option>
                        <option value="menunggu">⏳ Menunggu (Belum dijadwalkan)</option>
                        <option value="dibatalkan">❌ Dibatalkan</option>
                    </select>
                </div>

                {{-- Catatan / Instruksi Petugas --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Catatan Petugas / Armada (Opsional)
                    </label>
                    <input type="text" name="catatan_petugas" id="mCatatanPetugas"
                        placeholder="Contoh: Motor bentor BE-1234 berangkat pukul 09.30 WIB..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                    <p class="text-[11px] text-slate-400 mt-1">
                        Catatan ini dapat dibaca oleh nasabah di halaman akun mereka.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeTugaskanModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold shadow-lg shadow-emerald-700/20 transition flex items-center gap-1.5">
                        <span>💾</span> Simpan Penugasan & Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Instant search
        document.getElementById('searchJemput')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.jemput-row').forEach(r => {
                const text = r.textContent.toLowerCase();
                r.style.display = text.includes(q) ? '' : 'none';
            });
        });

        // Open modal
        function openTugaskanModal(id, kode, nama, alamat, status, idPetugas, catatan) {
            document.getElementById('formTugaskan').action = `/admin/jemput-bentor/${id}/update`;
            document.getElementById('mKodeJemput').innerText = kode;
            document.getElementById('mNamaNasabah').innerText = nama;
            document.getElementById('mAlamatJemput').innerText = alamat;

            const selStatus = document.getElementById('mSelectStatus');
            selStatus.value = status || 'dijadwalkan';

            const selPetugas = document.getElementById('mSelectPetugas');
            selPetugas.value = idPetugas || '';

            document.getElementById('mCatatanPetugas').value = catatan || '';

            document.getElementById('modalTugaskan').classList.remove('hidden');
        }

        function closeTugaskanModal() {
            document.getElementById('modalTugaskan').classList.add('hidden');
        }
    </script>
</body>
</html>