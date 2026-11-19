<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tabungan & Riwayat - Bank Sampah Bumi Sai Wawai</title>
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
                <h1 class="font-bold text-base">Buku Tabungan & Mutasi Rekening</h1>
            </div>
            <div class="text-right">
                <p class="text-xs text-emerald-200">Total Saldo Aktif:</p>
                <p class="text-sm font-extrabold text-white">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</p>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8 flex-1 w-full space-y-8">
        <!-- Buku Besar Mutasi Saldo -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Buku Mutasi Kas Tabungan</h2>
                    <p class="text-xs text-slate-500">Pencatatan saldo masuk (kredit) dan keluar (debit) secara transparan.</p>
                </div>
                <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full font-semibold">Ternormalisasi 3NF</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100">
                        <tr>
                            <th class="p-3">Waktu Transaksi</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Keterangan</th>
                            <th class="p-3 text-right">Mutasi (Rp)</th>
                            <th class="p-3 text-right">Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mutasi as $m)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 text-slate-500 font-medium">
                                    {{ $m->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="p-3">
                                    @if ($m->jenis_mutasi === 'kredit')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            + Kredit (Masuk)
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">
                                            - Debit (Keluar)
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 text-slate-700 max-w-xs">
                                    <p class="font-semibold">{{ $m->keterangan }}</p>
                                    @if($m->referensi_kode)
                                        <span class="text-[10px] text-slate-400 font-mono">Ref: {{ $m->referensi_kode }}</span>
                                    @endif
                                </td>
                                <td class="p-3 text-right font-bold {{ $m->jenis_mutasi === 'kredit' ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $m->jenis_mutasi === 'kredit' ? '+' : '-' }} Rp {{ number_format($m->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-right font-extrabold text-slate-800">
                                    Rp {{ number_format($m->saldo_sesudah, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">
                                    Belum ada catatan mutasi saldo tabungan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $mutasi->links() }}
            </div>
        </div>

        <!-- Rincian Nota Penimbangan Sampah -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 mb-1">Riwayat Nota Penimbangan Sampah</h2>
            <p class="text-xs text-slate-500 mb-4">Daftar sampah yang disetor dan ditimbang oleh petugas bank sampah.</p>

            <div class="space-y-4">
                @forelse ($riwayatSetor as $trx)
                    <div class="p-4 rounded-xl border border-slate-200/80 bg-slate-50/50">
                        <div class="flex flex-wrap items-center justify-between pb-3 border-b border-slate-200/60 mb-3 gap-2">
                            <div>
                                <span class="text-xs font-mono font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded">
                                    {{ $trx->kode_transaksi }}
                                </span>
                                <span class="text-xs text-slate-500 ml-2">{{ $trx->tanggal_setor->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-slate-500">Ditimbang oleh: <b>{{ $trx->petugas->nama_lengkap ?? 'Staf Bank Sampah' }}</b></span>
                                <a href="{{ route('nasabah.nota', $trx->id_transaksi_setor) }}" target="_blank"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-white hover:bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-300 shadow-sm transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Cetak Resi
                                </a>
                            </div>
                        </div>

                        <!-- Item rincian -->
                        <div class="space-y-1.5 mb-3">
                            @foreach ($trx->details as $d)
                                <div class="flex items-center justify-between text-xs py-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span class="font-semibold text-slate-700">{{ $d->sampah->nama_sampah ?? 'Sampah' }}</span>
                                        <span class="text-slate-400">({{ number_format($d->jumlah_satuan, 1) }} {{ $d->sampah->satuan ?? 'kg' }} &times; Rp {{ number_format($d->harga_saat_transaksi, 0, ',', '.') }})</span>
                                    </div>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs">
                            <span class="font-semibold text-slate-600">Total Berat: <b>{{ number_format($trx->total_berat, 1) }} Kg</b></span>
                            <span class="text-sm font-extrabold text-emerald-700">Total Saldo Didapat: Rp {{ number_format($trx->total_nominal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-xs text-slate-400 py-6">Belum ada riwayat penimbangan sampah.</p>
                @endforelse
            </div>
        </div>
    </main>

    {{-- Maskot Interaktif Si Wawai --}}
    @include('components.mascot-siwawai')
</body>
</html>

