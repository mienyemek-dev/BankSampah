<?php

namespace App\Http\Controllers;

use App\Models\MutasiSaldo;
use App\Models\PenarikanSaldo;
use App\Models\PenjualanPengepul;
use App\Models\TransaksiProduk;
use App\Models\TransaksiSetor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KeuanganController extends Controller
{
    /**
     * Dashboard Panel Keuangan
     */
    public function dashboard()
    {
        $totalSimpananNasabah = User::where('role', 'nasabah')->sum('saldo');
        $antreanPencairan = PenarikanSaldo::where('status_penarikan', 'diajukan')->count();
        $totalPencairanSelesai = PenarikanSaldo::where('status_penarikan', 'selesai')->sum('nominal_penarikan');
        $totalPendapatanPengepul = PenjualanPengepul::sum('total_pendapatan');

        $permohonanTerbaru = PenarikanSaldo::with('nasabah')
            ->where('status_penarikan', 'diajukan')
            ->latest('tanggal_pengajuan')
            ->take(5)
            ->get();

        $mutasiTerbaru = MutasiSaldo::with('user')
            ->latest('created_at')
            ->take(8)
            ->get();

        return view('keuangan.dashboard', compact(
            'totalSimpananNasabah',
            'antreanPencairan',
            'totalPencairanSelesai',
            'totalPendapatanPengepul',
            'permohonanTerbaru',
            'mutasiTerbaru'
        ));
    }

    /**
     * Daftar Seluruh Permohonan Penarikan Saldo
     */
    public function penarikanIndex()
    {
        $penarikanList = PenarikanSaldo::with(['nasabah', 'admin'])
            ->latest('tanggal_pengajuan')
            ->paginate(15);

        return view('keuangan.penarikan_index', compact('penarikanList'));
    }

    /**
     * Eksekusi Verifikasi & Pencairan Dana (Payout)
     */
    public function prosesPencairan(Request $request, $id_penarikan)
    {
        $penarikan = PenarikanSaldo::with('nasabah')->findOrFail($id_penarikan);

        $action = $request->input('action'); // 'setujui' atau 'tolak'

        if ($action === 'tolak') {
            $alasan = $request->input('catatan_admin', 'Rekening bank tidak valid / nama tidak sesuai.');

            DB::transaction(function () use ($penarikan, $alasan) {
                // Kembalikan saldo nasabah yang di-hold
                $nasabah = $penarikan->nasabah;
                $saldoSebelum = $nasabah->saldo;
                $saldoSesudah = $saldoSebelum + $penarikan->nominal_penarikan;

                $nasabah->update(['saldo' => $saldoSesudah]);

                $penarikan->update([
                    'status_penarikan' => 'ditolak',
                    'id_admin' => Auth::id(),
                    'catatan_admin' => $alasan,
                    'tanggal_selesai' => now(),
                ]);

                // Catat mutasi pengembalian saldo (Refund)
                MutasiSaldo::create([
                    'id_user' => $nasabah->id_user,
                    'jenis_mutasi' => 'kredit',
                    'jumlah' => $penarikan->nominal_penarikan,
                    'saldo_sebelum' => $saldoSebelum,
                    'saldo_sesudah' => $saldoSesudah,
                    'kategori_transaksi' => 'refund_penarikan',
                    'referensi_kode' => $penarikan->kode_penarikan,
                    'keterangan' => 'Pengembalian dana penarikan karena ditolak admin: ' . $alasan,
                ]);
            });

            return back()->with('info', 'Permohonan penarikan telah ditolak dan saldo telah dikembalikan ke akun nasabah.');
        }

        // Jika disetujui & dicairkan
        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        $penarikan->update([
            'status_penarikan' => 'selesai',
            'id_admin' => Auth::id(),
            'bukti_transfer_path' => $buktiPath ?? 'simulasi_transfer_' . strtoupper(Str::random(8)) . '.jpg',
            'catatan_admin' => $request->input('catatan_admin', 'Dana berhasil ditransfer ke rekening nasabah.'),
            'tanggal_selesai' => now(),
        ]);

        return back()->with('success', 'Dana sebesar Rp ' . number_format($penarikan->nominal_penarikan, 0, ',', '.') . ' berhasil dicairkan ke rekening ' . $penarikan->nama_bank . ' (' . $penarikan->nomor_rekening . ') an. ' . $penarikan->atas_nama);
    }

    /**
     * Buku Kas & Laporan Finansial
     */
    public function bukuKas()
    {
        $mutasiKas = MutasiSaldo::with('user')->latest('created_at')->paginate(20);
        $totalSetor = TransaksiSetor::sum('total_nominal');
        $totalPencairan = PenarikanSaldo::where('status_penarikan', 'selesai')->sum('nominal_penarikan');
        $totalPenjualanPabrik = PenjualanPengepul::sum('total_pendapatan');

        return view('keuangan.buku_kas', compact('mutasiKas', 'totalSetor', 'totalPencairan', 'totalPenjualanPabrik'));
    }
}

