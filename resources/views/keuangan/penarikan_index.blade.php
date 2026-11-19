<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pencairan Saldo - Panel Keuangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex">

    {{-- SIDEBAR BENDAHARA --}}
    <aside class="w-64 bg-gradient-to-b from-emerald-950 via-emerald-900 to-emerald-950 text-white flex flex-col flex-shrink-0 min-h-screen sticky top-0 border-r border-emerald-800/70 z-30 shadow-2xl">
        <div class="p-5 border-b border-emerald-800/70 bg-emerald-950/50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-10 h-10 rounded-full border border-emerald-400/50 object-cover shadow-md">
                <div>
                    <h2 class="font-extrabold text-sm leading-tight text-white drop-shadow-sm">Bank Sampah</h2>
                    <p class="text-xs text-emerald-300 font-semibold drop-shadow-sm">Bumi Sai Wawai</p>
                </div>
            </div>
            <div class="mt-3.5 px-3 py-1.5 rounded-xl bg-emerald-900/80 border border-emerald-700/60 flex items-center justify-between shadow-inner">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-emerald-100 uppercase tracking-wider">Bendahara & Kas</span>
                </div>
                <span class="text-[10px] text-emerald-300 font-extrabold">Aktif</span>
            </div>
        </div>

        <nav class="p-3.5 space-y-1.5 flex-1 overflow-y-auto">
            <a href="{{ route('keuangan.dashboard') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <span class="text-base group-hover:scale-110 transition">📊</span>
                <span>Dashboard Kas</span>
            </a>

            <a href="{{ route('keuangan.penarikan') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-md shadow-emerald-950/40 border border-emerald-400/40 transition">
                <span class="text-base">📲</span>
                <span>Pencairan E-Wallet</span>
            </a>

            <a href="{{ route('keuangan.buku_kas') }}"
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white text-xs font-semibold transition group">
                <div class="flex items-center gap-3">
                    <span class="text-base group-hover:scale-110 transition">📒</span>
                    <span>Mutasi & Buku Kas</span>
                </div>
            </a>
        </nav>

        <div class="p-4 border-t border-emerald-800/70 bg-emerald-950/50">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-emerald-700 border border-emerald-500/50 flex items-center justify-center font-extrabold text-sm text-white shadow-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'B', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->nama_lengkap ?? 'Bendahara' }}</p>
                    <p class="text-[10px] text-emerald-400 truncate">{{ Auth::user()->email ?? 'keuangan@saiwawai.id' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm">
                    <span>🚪</span> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto">
        {{-- Top Header --}}
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-base font-bold text-slate-800">📲 Permohonan Pencairan Dana Nasabah</h1>
                <p class="text-xs text-slate-500 mt-0.5">Otorisasi transfer dana e-wallet & rekening nasabah</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs bg-amber-100 text-amber-800 font-bold px-3 py-1.5 rounded-full border border-amber-200">
                    ⏳ Menunggu Otorisasi
                </span>
            </div>
        </div>

        <div class="p-8 space-y-6 max-w-7xl">

            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-sm">
                    <span>✅</span>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm flex items-center gap-2 shadow-sm">
                    <span>ℹ️</span>
                    <span class="font-semibold">{{ session('info') }}</span>
                </div>
            @endif

            {{-- Stats Ringkas --}}
            <div class="grid grid-cols-3 gap-4">
                @php
                    $menunggu = $penarikanList->where('status_penarikan', 'diajukan')->count();
                    $selesai  = $penarikanList->where('status_penarikan', 'selesai')->count();
                    $ditolak  = $penarikanList->where('status_penarikan', 'ditolak')->count();
                @endphp
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-xl">⏳</div>
                    <div>
                        <p class="text-2xl font-extrabold text-amber-700">{{ $menunggu }}</p>
                        <p class="text-xs text-slate-500 font-semibold">Menunggu Proses</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-xl">✅</div>
                    <div>
                        <p class="text-2xl font-extrabold text-emerald-700">{{ $selesai }}</p>
                        <p class="text-xs text-slate-500 font-semibold">Selesai Dicairkan</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-xl">❌</div>
                    <div>
                        <p class="text-2xl font-extrabold text-rose-600">{{ $ditolak }}</p>
                        <p class="text-xs text-slate-500 font-semibold">Ditolak</p>
                    </div>
                </div>
            </div>

            {{-- Tabel Pencairan --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Daftar Semua Permohonan Penarikan</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tinjau antrean penarikan dana nasabah dan cairkan ke rekening tujuan</p>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchPenarikan" placeholder="Cari nama / kode..."
                            class="pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-none w-52 bg-white">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs" id="tablePenarikan">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3.5">Kode & Tanggal</th>
                                <th class="p-3.5">Nama Nasabah</th>
                                <th class="p-3.5">Rekening / E-Wallet Tujuan</th>
                                <th class="p-3.5 text-right">Nominal</th>
                                <th class="p-3.5 text-center">Status</th>
                                <th class="p-3.5 text-center">Aksi / Otorisasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($penarikanList as $pen)
                                <tr class="hover:bg-slate-50 transition pen-row">
                                    <td class="p-3.5">
                                        <span class="font-mono font-bold text-slate-800">{{ $pen->kode_penarikan }}</span>
                                        <p class="text-[11px] text-slate-400">{{ $pen->tanggal_pengajuan->format('d M Y, H:i') }}</p>
                                    </td>
                                    <td class="p-3.5 font-semibold text-slate-700">
                                        {{ $pen->nasabah->nama_lengkap ?? 'Nasabah' }}
                                        <p class="text-[11px] text-slate-400 font-normal">{{ $pen->nasabah->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="p-3.5">
                                        @php
                                            $bank = strtoupper($pen->nama_bank ?? '');
                                            $badgeColor = match(true) {
                                                str_contains($bank,'DANA')   => 'bg-blue-100 text-blue-800',
                                                str_contains($bank,'GOPAY')  => 'bg-sky-100 text-sky-800',
                                                str_contains($bank,'OVO')    => 'bg-purple-100 text-purple-800',
                                                str_contains($bank,'SHOPEEPAY') => 'bg-orange-100 text-orange-800',
                                                default                      => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $badgeColor }} mb-1">
                                            {{ $pen->nama_bank }}
                                        </span>
                                        <p class="text-xs text-slate-700 font-mono font-bold">{{ $pen->nomor_rekening }}</p>
                                        <p class="text-[11px] text-slate-400">a.n. {{ $pen->atas_nama }}</p>
                                    </td>
                                    <td class="p-3.5 text-right font-black text-emerald-700 text-sm whitespace-nowrap">
                                        Rp {{ number_format($pen->nominal_penarikan, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3.5 text-center whitespace-nowrap">
                                        @if ($pen->status_penarikan === 'diajukan')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Otorisasi
                                            </span>
                                        @elseif ($pen->status_penarikan === 'selesai')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                <span>✅</span> Selesai Ditransfer
                                            </span>
                                        @elseif ($pen->status_penarikan === 'ditolak')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                                <span>❌</span> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center whitespace-nowrap">
                                        @if ($pen->status_penarikan === 'diajukan')
                                            <div class="inline-flex items-center gap-2">
                                                {{-- Tombol Buka Modal Pencairan --}}
                                                <button type="button"
                                                    onclick="openCairkanModal({{ $pen->id_penarikan }}, '{{ $pen->kode_penarikan }}', '{{ addslashes($pen->nasabah->nama_lengkap ?? 'Nasabah') }}', '{{ addslashes($pen->nama_bank) }}', '{{ $pen->nomor_rekening }}', '{{ addslashes($pen->atas_nama) }}', {{ $pen->nominal_penarikan }})"
                                                    class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-sm flex items-center gap-1">
                                                    <span>✔</span> Cairkan Dana
                                                </button>

                                                {{-- Tombol Buka Modal Tolak --}}
                                                <button type="button"
                                                    onclick="openTolakModal({{ $pen->id_penarikan }}, '{{ $pen->kode_penarikan }}', '{{ addslashes($pen->nasabah->nama_lengkap ?? 'Nasabah') }}', {{ $pen->nominal_penarikan }})"
                                                    class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition">
                                                    Tolak
                                                </button>
                                            </div>
                                        @elseif ($pen->status_penarikan === 'selesai')
                                            {{-- Tombol Lihat Bukti / Resi Transfer --}}
                                            <button type="button"
                                                onclick="openBuktiModal('{{ $pen->kode_penarikan }}', '{{ $pen->tanggal_selesai ? $pen->tanggal_selesai->format('d M Y, H:i') : $pen->tanggal_pengajuan->format('d M Y, H:i') }}', '{{ addslashes($pen->nasabah->nama_lengkap ?? 'Nasabah') }}', '{{ addslashes($pen->nama_bank) }}', '{{ $pen->nomor_rekening }}', '{{ addslashes($pen->atas_nama) }}', {{ $pen->nominal_penarikan }}, '{{ addslashes($pen->catatan_admin ?? 'Dana berhasil ditransfer ke rekening nasabah.') }}', '{{ $pen->bukti_transfer_path }}')"
                                                class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-slate-700 border border-slate-200 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-xs mx-auto">
                                                <span>📄</span> Lihat Bukti Transfer
                                            </button>
                                        @else
                                            <span class="text-xs text-rose-500 font-semibold italic">Permohonan Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-slate-400">
                                        <div class="text-4xl mb-2">🎉</div>
                                        <p class="font-bold text-slate-600">Tidak ada antrean pencairan dana</p>
                                        <p class="text-xs text-slate-400 mt-1">Semua permohonan penarikan saldo nasabah telah diproses</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($penarikanList->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $penarikanList->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>

    {{-- ============================================================ --}}
    {{-- MODAL 1: PROSES PENCAIRAN DANA (UPLOAD BUKTI & CATATAN)      --}}
    {{-- ============================================================ --}}
    <div id="modalCairkan" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95">
            
            {{-- Modal Header --}}
            <div class="p-6 bg-gradient-to-r from-emerald-800 to-teal-800 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">💸</span>
                    <div>
                        <h3 class="text-base font-bold">Otorisasi Pencairan Dana</h3>
                        <p class="text-xs text-emerald-200" id="cairKode">SLS-XXXXXX</p>
                    </div>
                </div>
                <button type="button" onclick="closeCairkanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                    ✕
                </button>
            </div>

            <form id="formProsesCairkan" method="POST" action="" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="action" value="setujui">

                {{-- Detail Rekening Penerima --}}
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">Nasabah Penerima:</span>
                        <span class="font-bold text-slate-800" id="cairNama">-</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">E-Wallet / Bank:</span>
                        <span class="font-bold text-blue-700" id="cairBank">-</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">Nomor Akun / HP:</span>
                        <span class="font-mono font-bold text-slate-800" id="cairNorek">-</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">Atas Nama Akun:</span>
                        <span class="font-semibold text-slate-700" id="cairAtasNama">-</span>
                    </div>
                    <div class="pt-2 border-t border-slate-200 flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-700 uppercase">Jumlah Ditransfer:</span>
                        <span class="text-lg font-black text-emerald-700" id="cairNominal">Rp 0</span>
                    </div>
                </div>

                {{-- Upload Bukti Transfer --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Upload Bukti Transfer / Resi (Opsional)
                    </label>
                    <input type="file" name="bukti_transfer" id="inputBuktiTransfer" accept="image/*"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1 cursor-pointer">
                    
                    {{-- Status Kompresi --}}
                    <div id="compressStatus" class="mt-2 hidden">
                        <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-2 text-xs text-amber-800">
                            <span class="animate-spin text-base">⏳</span>
                            <span id="compressStatusText">Mengompresi foto bukti transfer agar ringan dan cepat...</span>
                        </div>
                    </div>

                    {{-- Preview Thumbnail Hasil Kompresi --}}
                    <div id="compressPreview" class="mt-2 hidden">
                        <div class="p-2 rounded-xl border border-emerald-200 bg-emerald-50/60 flex items-center justify-between">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <img id="imgThumbnail" src="" class="w-10 h-10 rounded-lg object-cover border border-emerald-300 flex-shrink-0 shadow-xs">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-800 truncate" id="compressFileName">-</p>
                                    <p class="text-[11px] text-emerald-700 font-semibold" id="compressFileSize">-</p>
                                </div>
                            </div>
                            <button type="button" onclick="removeSelectedFile()" class="text-rose-600 hover:text-rose-800 text-xs font-bold px-2 py-1 rounded-lg hover:bg-rose-50 transition">
                                Hapus
                            </button>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-400 mt-1.5 leading-relaxed">
                        Foto otomatis dikompresi menjadi ringan (&lt; 300 KB). Jika dikosongkan, sistem membuat stempel resi digital resmi otomatis.
                    </p>
                </div>

                {{-- Catatan Admin / No Referensi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        No. Referensi / Catatan Transfer
                    </label>
                    <input type="text" name="catatan_admin" placeholder="Contoh: Ref M-Banking #892819283 / Transfer DANA sukses"
                        value="Dana berhasil ditransfer ke rekening nasabah."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                {{-- Action Buttons --}}
                <div class="pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeCairkanModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitCair" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold shadow-lg shadow-emerald-700/20 transition flex items-center gap-1.5">
                        <span>✔</span> Konfirmasi & Selesaikan Pencairan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL 2: TOLAK PENCAIRAN DANA                                --}}
    {{-- ============================================================ --}}
    <div id="modalTolak" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95">
            <div class="p-6 bg-gradient-to-r from-rose-700 to-rose-900 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⚠️</span>
                    <div>
                        <h3 class="text-base font-bold">Tolak Permohonan Pencairan</h3>
                        <p class="text-xs text-rose-200" id="tolakKode">SLS-XXXXXX</p>
                    </div>
                </div>
                <button type="button" onclick="closeTolakModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                    ✕
                </button>
            </div>

            <form id="formProsesTolak" method="POST" action="" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="action" value="tolak">

                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-800 leading-relaxed">
                    💡 <b>Perhatian:</b> Menolak permohonan ini akan secara otomatis <b>mengembalikan saldo tabungan Rp <span id="tolakNominal" class="font-bold">0</span></b> ke akun nasabah <b id="tolakNama">-</b>.
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Alasan Penolakan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="catatan_admin" rows="3" required placeholder="Contoh: Nomor akun DANA tidak terdaftar atau nama pemilik rekening berbeda..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-2 focus:ring-rose-500">Nomor rekening/e-wallet tidak valid atau nama tidak sesuai.</textarea>
                </div>

                <div class="pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeTolakModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-lg shadow-rose-700/20 transition">
                        Tolak & Kembalikan Saldo
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL 3: LIHAT RESI / BUKTI TRANSFER DIGITAL RESMI           --}}
    {{-- ============================================================ --}}
    <div id="modalBukti" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95">
            
            {{-- Struk Header --}}
            <div class="p-6 bg-gradient-to-br from-emerald-900 to-teal-950 text-white text-center relative">
                <button type="button" onclick="closeBuktiModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition">
                    ✕
                </button>
                <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-12 h-12 rounded-full border-2 border-emerald-400 mx-auto mb-2 object-cover shadow-md">
                <h3 class="text-sm font-black uppercase tracking-wider text-emerald-300">Bank Sampah Bumi Sai Wawai</h3>
                <p class="text-xs text-emerald-100 font-semibold mt-0.5">Bukti Resmi Pencairan Dana Nasabah</p>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[10px] font-bold mt-2">
                    <span>✅</span> DANA BERHASIL DITRANSFER
                </div>
            </div>

            {{-- Detail Struk --}}
            <div class="p-6 space-y-4 text-xs">
                <div class="border-b border-dashed border-slate-200 pb-3 space-y-1.5">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Kode Transaksi</span>
                        <span class="font-mono font-bold text-slate-800" id="resKode">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Waktu Selesai</span>
                        <span class="font-semibold text-slate-700" id="resTanggal">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Penerima</span>
                        <span class="font-bold text-slate-800" id="resNama">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Bank / E-Wallet</span>
                        <span class="font-bold text-blue-700" id="resBank">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Nomor Rekening / HP</span>
                        <span class="font-mono font-bold text-slate-800" id="resNorek">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Atas Nama</span>
                        <span class="font-semibold text-slate-700" id="resAtasNama">-</span>
                    </div>
                </div>

                {{-- Nominal Besar --}}
                <div class="p-3.5 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Total Pencairan</span>
                        <span class="text-xs text-slate-500">Bebas Biaya Admin</span>
                    </div>
                    <span class="text-xl font-black text-emerald-700" id="resNominal">Rp 0</span>
                </div>

                {{-- Catatan Admin --}}
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-600">
                    <p class="text-[10px] uppercase font-bold text-slate-400 mb-0.5">Catatan Transfer:</p>
                    <p class="font-semibold text-slate-700 italic" id="resCatatan">-</p>
                </div>

                {{-- Lampiran Gambar Bukti jika ada --}}
                <div id="resFotoContainer" class="hidden">
                    <p class="text-[10px] uppercase font-bold text-slate-400 mb-1.5">Lampiran Foto Bukti Transfer:</p>
                    <div class="rounded-xl overflow-hidden border border-slate-200 max-h-48">
                        <img id="resFoto" src="" alt="Bukti Transfer" class="w-full object-contain">
                    </div>
                </div>

                {{-- Close / Print Button --}}
                <div class="pt-2 flex items-center gap-2">
                    <button type="button" onclick="window.print()" class="flex-1 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1.5">
                        <span>🖨️</span> Cetak Resi
                    </button>
                    <button type="button" onclick="closeBuktiModal()" class="flex-1 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Instant search filter
        document.getElementById('searchPenarikan')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.pen-row').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });

        // Client-side auto-compression for uploaded receipt image
        const inputBukti = document.getElementById('inputBuktiTransfer');
        let isCompressing = false;

        inputBukti?.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Mohon pilih file gambar foto/screenshot (JPG, PNG).');
                inputBukti.value = '';
                return;
            }

            const statusEl = document.getElementById('compressStatus');
            const previewEl = document.getElementById('compressPreview');
            const statusText = document.getElementById('compressStatusText');
            const btnSubmit = document.getElementById('btnSubmitCair');

            statusEl.classList.remove('hidden');
            previewEl.classList.add('hidden');
            statusText.innerText = 'Mengompresi foto bukti transfer agar ringan dan cepat...';
            btnSubmit.disabled = true;
            isCompressing = true;

            try {
                const compressedFile = await compressImageFile(file, 1200, 1200, 0.75);
                
                // Pasang file terkompresi ke input menggunakan DataTransfer
                const dt = new DataTransfer();
                dt.items.add(compressedFile);
                inputBukti.files = dt.files;

                const origKB = Math.round(file.size / 1024);
                const compKB = Math.round(compressedFile.size / 1024);

                document.getElementById('compressFileName').innerText = compressedFile.name;
                document.getElementById('compressFileSize').innerText = `Terkompresi: ${compKB} KB (Aman diupload, dari ${origKB} KB)`;
                
                const reader = new FileReader();
                reader.onload = (re) => {
                    document.getElementById('imgThumbnail').src = re.target.result;
                    previewEl.classList.remove('hidden');
                };
                reader.readAsDataURL(compressedFile);

            } catch (err) {
                console.error('Gagal kompres:', err);
            } finally {
                statusEl.classList.add('hidden');
                btnSubmit.disabled = false;
                isCompressing = false;
            }
        });

        function removeSelectedFile() {
            if (inputBukti) inputBukti.value = '';
            document.getElementById('compressPreview')?.classList.add('hidden');
        }

        function compressImageFile(file, maxWidth, maxHeight, quality) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = () => {
                        let w = img.width;
                        let h = img.height;
                        if (w > h) {
                            if (w > maxWidth) {
                                h = Math.round((h * maxWidth) / w);
                                w = maxWidth;
                            }
                        } else {
                            if (h > maxHeight) {
                                w = Math.round((w * maxHeight) / h);
                                h = maxHeight;
                            }
                        }
                        const canvas = document.createElement('canvas');
                        canvas.width = w;
                        canvas.height = h;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, w, h);
                        canvas.toBlob((blob) => {
                            if (!blob) {
                                resolve(file);
                                return;
                            }
                            const newFile = new File([blob], file.name.replace(/\.[^/.]+$/, "") + ".jpg", {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            resolve(newFile);
                        }, 'image/jpeg', quality);
                    };
                    img.onerror = () => resolve(file);
                };
                reader.onerror = () => resolve(file);
            });
        }

        // Form submit handler
        document.getElementById('formProsesCairkan')?.addEventListener('submit', function(e) {
            if (isCompressing) {
                e.preventDefault();
                alert('Mohon tunggu sejenak, foto sedang dioptimasi...');
                return false;
            }
            const btn = document.getElementById('btnSubmitCair');
            btn.disabled = true;
            btn.innerHTML = '<span>⏳</span> Memproses Pencairan...';
        });

        // Modal Cairkan
        function openCairkanModal(id, kode, nama, bank, norek, atasNama, nominal) {
            document.getElementById('formProsesCairkan').action = `/keuangan/penarikan-saldo/${id}/proses`;
            document.getElementById('cairKode').innerText = kode;
            document.getElementById('cairNama').innerText = nama;
            document.getElementById('cairBank').innerText = bank;
            document.getElementById('cairNorek').innerText = norek;
            document.getElementById('cairAtasNama').innerText = atasNama;
            document.getElementById('cairNominal').innerText = 'Rp ' + Number(nominal).toLocaleString('id-ID');
            removeSelectedFile();
            document.getElementById('modalCairkan').classList.remove('hidden');
        }

        function closeCairkanModal() {
            document.getElementById('modalCairkan').classList.add('hidden');
        }

        // Modal Tolak
        function openTolakModal(id, kode, nama, nominal) {
            document.getElementById('formProsesTolak').action = `/keuangan/penarikan-saldo/${id}/proses`;
            document.getElementById('tolakKode').innerText = kode;
            document.getElementById('tolakNama').innerText = nama;
            document.getElementById('tolakNominal').innerText = Number(nominal).toLocaleString('id-ID');
            document.getElementById('modalTolak').classList.remove('hidden');
        }

        function closeTolakModal() {
            document.getElementById('modalTolak').classList.add('hidden');
        }

        // Modal Lihat Bukti Resi
        function openBuktiModal(kode, tanggal, nama, bank, norek, atasNama, nominal, catatan, buktiPath) {
            document.getElementById('resKode').innerText = kode;
            document.getElementById('resTanggal').innerText = tanggal;
            document.getElementById('resNama').innerText = nama;
            document.getElementById('resBank').innerText = bank;
            document.getElementById('resNorek').innerText = norek;
            document.getElementById('resAtasNama').innerText = atasNama;
            document.getElementById('resNominal').innerText = 'Rp ' + Number(nominal).toLocaleString('id-ID');
            document.getElementById('resCatatan').innerText = catatan || 'Dana berhasil ditransfer ke rekening nasabah.';

            const fotoContainer = document.getElementById('resFotoContainer');
            const fotoImg = document.getElementById('resFoto');
            if (buktiPath && !buktiPath.startsWith('simulasi_')) {
                fotoImg.src = `/storage/${buktiPath}`;
                fotoContainer.classList.remove('hidden');
            } else {
                fotoContainer.classList.add('hidden');
            }

            document.getElementById('modalBukti').classList.remove('hidden');
        }

        function closeBuktiModal() {
            document.getElementById('modalBukti').classList.add('hidden');
        }
    </script>

</body>
</html>