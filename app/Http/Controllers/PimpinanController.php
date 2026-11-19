<?php

namespace App\Http\Controllers;

use App\Models\MutasiSaldo;
use App\Models\PenarikanSaldo;
use App\Models\PenjualanPengepul;
use App\Models\PermohonanJemput;
use App\Models\Sampah;
use App\Models\TransaksiSetor;
use App\Models\TransitLimbahMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanController extends Controller
{
    /**
     * Dashboard Eksekutif Pimpinan Bank Sampah (Superadmin)
     */
    public function dashboard()
    {
        // 1. Metrik Nasabah
        $totalNasabah = User::where('role', 'nasabah')->count();
        $totalNasabahAktif = User::where('role', 'nasabah')->where('status_akun', 'aktif')->count();
        $totalSaldoNasabah = User::where('role', 'nasabah')->sum('saldo');

        // 2. Metrik Operasional Sampah
        $totalKgSampah = TransaksiSetor::where('status_setor', 'selesai')->sum('total_berat');
        $totalTransaksiSetor = TransaksiSetor::where('status_setor', 'selesai')->count();
        $totalJemputBentor = PermohonanJemput::where('status_jemput', 'selesai')->count();

        // 3. Metrik Finansial
        $totalPenjualanPabrik = PenjualanPengepul::where('status_pembayaran', 'lunas')->sum('total_pendapatan');
        $totalPencairanNasabah = PenarikanSaldo::where('status_penarikan', 'disetujui')->sum('nominal_penarikan');
        $surplusOperasional = $totalPenjualanPabrik - $totalPencairanNasabah;

        // 4. Metrik Limbah Medis
        $totalLimbahMedisKg = TransitLimbahMedis::sum('berat_kg');

        // 5. Transaksi Setoran Terbaru
        $transaksiTerbaru = TransaksiSetor::with(['nasabah', 'petugas'])
            ->latest('tanggal_setor')
            ->take(6)
            ->get();

        // 6. Permohonan Pencairan Terbaru
        $pencairanTerbaru = PenarikanSaldo::with('nasabah')
            ->latest('created_at')
            ->take(5)
            ->get();

        // 7. Data Grafik Komposisi Sampah per Kategori
        $komposisiSampah = DB::table('detail_transaksi_setor')
            ->join('sampah', 'detail_transaksi_setor.id_sampah', '=', 'sampah.id_sampah')
            ->join('kategori_sampah', 'sampah.id_kategori_sampah', '=', 'kategori_sampah.id_kategori_sampah')
            ->select('kategori_sampah.nama_kategori', DB::raw('SUM(detail_transaksi_setor.jumlah_satuan) as total_berat'))
            ->groupBy('kategori_sampah.nama_kategori')
            ->get();

        return view('pimpinan.dashboard', compact(
            'totalNasabah',
            'totalNasabahAktif',
            'totalSaldoNasabah',
            'totalKgSampah',
            'totalTransaksiSetor',
            'totalJemputBentor',
            'totalPenjualanPabrik',
            'totalPencairanNasabah',
            'surplusOperasional',
            'totalLimbahMedisKg',
            'transaksiTerbaru',
            'pencairanTerbaru',
            'komposisiSampah'
        ));
    }
}
