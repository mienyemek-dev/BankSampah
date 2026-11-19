<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi #{{ $transaksi->kode_transaksi }} – Bank Sampah Bumi Sai Wawai</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Space Mono', monospace;
            background-color: #f1f5f9;
        }
        .receipt-paper {
            width: 80mm;
            max-width: 100%;
            background: white;
            margin: 20px auto;
            padding: 18px 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-radius: 4px;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.4;
        }
        .dashed-line {
            border-top: 1px dashed #64748b;
            margin: 10px 0;
        }
        .double-line {
            border-top: 2px dashed #0f172a;
            margin: 10px 0;
        }
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .receipt-paper {
                box-shadow: none !important;
                margin: 0 auto !important;
                padding: 5px 8px !important;
                width: 100% !important;
                max-width: 80mm !important;
            }
        }
    </style>
</head>
<body class="p-4">

    <!-- Action Bar (Hanya tampil di layar, disembunyikan saat cetak) -->
    <div class="max-w-[80mm] mx-auto mb-3 flex items-center justify-between gap-2 no-print">
        <a href="{{ route('admin.timbang') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-sans font-bold text-xs py-2 px-3 rounded-lg transition flex items-center gap-1">
            ← Kembali
        </a>
        <button onclick="window.print()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-sans font-bold text-xs py-2 px-3 rounded-lg shadow flex items-center justify-center gap-1.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Struk
        </button>
    </div>

    <!-- Lembar Struk Fisik -->
    <div class="receipt-paper">
        <!-- Header -->
        <div class="text-center">
            <div class="font-bold text-sm tracking-wider uppercase">BANK SAMPAH</div>
            <div class="font-bold text-base tracking-widest text-emerald-800 uppercase">BUMI SAI WAWAI</div>
            <div class="text-[10px] text-slate-600 mt-1">Desa Banjar Rejo, Kec. Batanghari</div>
            <div class="text-[10px] text-slate-600">Kab. Lampung Timur - Lampung</div>
            <div class="text-[10px] text-slate-600">WhatsApp: +62 853-7932-4445</div>
        </div>

        <div class="double-line"></div>

        <!-- Meta Transaksi -->
        <div class="space-y-1 text-[10.5px]">
            <div class="flex justify-between">
                <span>No. Nota:</span>
                <span class="font-bold">{{ $transaksi->kode_transaksi }}</span>
            </div>
            <div class="flex justify-between">
                <span>Waktu:</span>
                <span>{{ $transaksi->tanggal_setor ? $transaksi->tanggal_setor->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Nasabah:</span>
                <span class="font-bold">{{ $transaksi->nasabah->nama_lengkap ?? 'Umum' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Metode:</span>
                <span class="uppercase font-semibold">
                    {{ $transaksi->metode_setor === 'jemput_bentor' ? 'Jemput Bentor' : 'Antar Langsung' }}
                </span>
            </div>
            <div class="flex justify-between">
                <span>Petugas:</span>
                <span>{{ $transaksi->petugas->nama_lengkap ?? 'Admin' }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Tabel Rincian Sampah -->
        <table class="w-full text-left text-[10.5px]">
            <thead>
                <tr class="border-b border-dashed border-slate-400">
                    <th class="pb-1">Jenis Sampah</th>
                    <th class="pb-1 text-center">Qty</th>
                    <th class="pb-1 text-right">Harga</th>
                    <th class="pb-1 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dotted divide-slate-300">
                @foreach ($transaksi->details as $d)
                    <tr>
                        <td class="py-1.5 font-bold" colspan="4">
                            {{ $d->sampah->nama_sampah ?? 'Sampah' }}
                        </td>
                    </tr>
                    <tr class="text-slate-600">
                        <td class="pb-1.5 text-[9.5px]">
                            {{ $d->sampah->kategori->nama_kategori ?? '-' }}
                        </td>
                        <td class="pb-1.5 text-center">
                            {{ number_format($d->jumlah_satuan, 1) }} {{ $d->sampah->satuan ?? 'kg' }}
                        </td>
                        <td class="pb-1.5 text-right">
                            {{ number_format($d->harga_saat_transaksi, 0, ',', '.') }}
                        </td>
                        <td class="pb-1.5 text-right font-bold text-slate-800">
                            {{ number_format($d->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="double-line"></div>

        <!-- Ringkasan Total -->
        <div class="space-y-1 text-[11px]">
            <div class="flex justify-between">
                <span>Total Berat Sampah:</span>
                <span class="font-bold">{{ number_format($transaksi->total_berat, 2) }} Kg</span>
            </div>
            <div class="flex justify-between font-bold text-xs pt-1 border-t border-slate-300">
                <span>SALDO MASUK (RP):</span>
                <span class="text-emerald-800 text-sm">Rp {{ number_format($transaksi->total_nominal, 0, ',', '.') }}</span>
            </div>
        </div>

        @if ($transaksi->catatan)
            <div class="mt-2 p-1.5 bg-slate-50 border border-slate-200 rounded text-[9.5px]">
                <span class="font-bold">Catatan:</span> {{ $transaksi->catatan }}
            </div>
        @endif

        <div class="dashed-line"></div>

        <!-- Footer Struk -->
        <div class="text-center space-y-1 text-[9.5px] text-slate-600">
            <p class="font-bold text-slate-700">*** TERIMA KASIH ***</p>
            <p>Sampah Anda telah menjadi berkah & tabungan bernilai ekonomis.</p>
            <p class="mt-2 text-[8.5px] text-slate-400">Dicetak otomatis dari Sistem Informasi Bank Sampah Bumi Sai Wawai</p>
        </div>

        <!-- Cap Digital Simulasi -->
        <div class="mt-4 pt-2 border-t border-dotted border-slate-300 flex justify-around text-center text-[9px] text-slate-500">
            <div>
                <p>Nasabah,</p>
                <div class="h-8"></div>
                <p class="font-semibold">({{ $transaksi->nasabah->nama_lengkap ?? 'Nasabah' }})</p>
            </div>
            <div>
                <p>Petugas Timbang,</p>
                <div class="h-8"></div>
                <p class="font-semibold">({{ $transaksi->petugas->nama_lengkap ?? 'Petugas' }})</p>
            </div>
        </div>
    </div>

    <!-- Script auto print -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Memberikan jeda singkat agar font termuat sempurna sebelum trigger dialog cetak
            setTimeout(() => {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>

