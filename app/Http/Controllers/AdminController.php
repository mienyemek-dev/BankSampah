<?php

namespace App\Http\Controllers;

use App\Models\BeritaEdukasi;
use App\Models\DetailPenjualanPengepul;
use App\Models\DetailTransaksiSetor;
use App\Models\KategoriSampah;
use App\Models\MutasiSaldo;
use App\Models\PenjualanPengepul;
use App\Models\PermohonanJemput;
use App\Models\Sampah;
use App\Models\TransaksiSetor;
use App\Models\TransitLimbahMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Dashboard Staf Administrasi
     */
    public function dashboard()
    {
        $totalNasabah = User::where('role', 'nasabah')->count();
        $totalKomoditas = Sampah::count();
        $jemputMenunggu = PermohonanJemput::where('status_jemput', 'menunggu')->count();
        $totalArtikel = BeritaEdukasi::count();

        // Metrik Ringkas Operasional Harian & Bulanan
        $totalSetorHariIni = TransaksiSetor::whereDate('tanggal_setor', today())->count();
        $totalBeratHariIni = TransaksiSetor::whereDate('tanggal_setor', today())->sum('total_berat');
        $totalBeratBulanIni = TransaksiSetor::whereMonth('tanggal_setor', date('m'))
            ->whereYear('tanggal_setor', date('Y'))
            ->sum('total_berat');

        $transaksiTerbaru = TransaksiSetor::with(['nasabah', 'details.sampah'])
            ->latest('tanggal_setor')
            ->take(8)
            ->get();

        $jemputTerbaru = PermohonanJemput::with('nasabah')
            ->latest('created_at')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalNasabah', 
            'totalKomoditas', 
            'jemputMenunggu', 
            'totalArtikel', 
            'totalSetorHariIni',
            'totalBeratHariIni',
            'totalBeratBulanIni',
            'transaksiTerbaru', 
            'jemputTerbaru'
        ));
    }

    /**
     * Halaman & Proses Timbang Setoran Sampah Nasabah
     */
    public function timbangIndex()
    {
        $nasabahList = User::where('role', 'nasabah')->where('status_akun', 'aktif')->orderBy('nama_lengkap')->get();
        $sampahList = Sampah::where('is_aktif', true)->with('kategori')->orderBy('nama_sampah')->get();
        $riwayatSetor = TransaksiSetor::with(['nasabah', 'details.sampah', 'petugas'])
            ->latest('tanggal_setor')
            ->paginate(10);

        return view('admin.timbang_sampah', compact('nasabahList', 'sampahList', 'riwayatSetor'));
    }

    public function timbangStore(Request $request)
    {
        $validated = $request->validate([
            'id_user' => ['required', 'exists:users,id_user'],
            'metode_setor' => ['required', 'in:antar_sendiri,jemput_bentor'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id_sampah' => ['required', 'exists:sampah,id_sampah'],
            'items.*.jumlah_satuan' => ['required', 'numeric', 'min:0.1'],
            'catatan' => ['nullable', 'string'],
        ], [
            'id_user.required' => 'Pilih nasabah yang menyetor sampah.',
            'items.required' => 'Minimal harus ada 1 jenis sampah yang ditimbang.',
            'items.*.jumlah_satuan.min' => 'Berat atau jumlah sampah minimal 0.1.',
        ]);

        $nasabah = User::findOrFail($validated['id_user']);
        $petugas = Auth::user();

        DB::transaction(function () use ($validated, $nasabah, $petugas) {
            $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $totalBerat = 0;
            $totalNominal = 0;

            // Buat header transaksi
            $transaksi = TransaksiSetor::create([
                'kode_transaksi' => $kodeTransaksi,
                'id_user' => $nasabah->id_user,
                'id_petugas' => $petugas->id_user,
                'tanggal_setor' => now(),
                'total_berat' => 0,
                'total_nominal' => 0,
                'metode_setor' => $validated['metode_setor'],
                'status_setor' => 'selesai',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // Simpan rincian tiap sampah yang ditimbang
            foreach ($validated['items'] as $item) {
                $sampah = Sampah::findOrFail($item['id_sampah']);
                $berat = (float) $item['jumlah_satuan'];
                $hargaSaatTransaksi = $sampah->harga_beli_nasabah;
                $subtotal = $berat * $hargaSaatTransaksi;

                DetailTransaksiSetor::create([
                    'id_transaksi_setor' => $transaksi->id_transaksi_setor,
                    'id_sampah' => $sampah->id_sampah,
                    'jumlah_satuan' => $berat,
                    'harga_saat_transaksi' => $hargaSaatTransaksi,
                    'subtotal' => $subtotal,
                ]);

                $totalBerat += $berat;
                $totalNominal += $subtotal;
            }

            // Update total di header
            $transaksi->update([
                'total_berat' => $totalBerat,
                'total_nominal' => $totalNominal,
            ]);

            // Tambahkan saldo dan berat kumulatif nasabah
            $saldoSebelum = $nasabah->saldo;
            $saldoSesudah = $saldoSebelum + $totalNominal;
            $beratKumulatifBaru = $nasabah->total_berat_sampah + $totalBerat;

            $nasabah->update([
                'saldo' => $saldoSesudah,
                'total_berat_sampah' => $beratKumulatifBaru,
            ]);

            // Catat buku besar mutasi (Kredit)
            MutasiSaldo::create([
                'id_user' => $nasabah->id_user,
                'jenis_mutasi' => 'kredit',
                'jumlah' => $totalNominal,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'kategori_transaksi' => 'setor_sampah',
                'referensi_kode' => $kodeTransaksi,
                'keterangan' => 'Penimbangan setoran sampah ' . number_format($totalBerat, 1) . ' Kg oleh petugas ' . $petugas->nama_lengkap,
            ]);
        });

        return redirect()->route('admin.timbang')->with('success', 'Penimbangan berhasil dicatat! Saldo sebesar Rp ' . number_format($transaksi->total_nominal ?? 0, 0, ',', '.') . ' otomatis bertambah ke akun nasabah.');
    }

    /**
     * Manajemen Data Nasabah
     */
    public function nasabahIndex()
    {
        $nasabahList = User::where('role', 'nasabah')->latest('created_at')->paginate(15);
        return view('admin.nasabah_index', compact('nasabahList'));
    }

    /**
     * Manajemen Armada Bentor (Permohonan Jemput)
     */
    public function jemputIndex()
    {
        $jemputList = PermohonanJemput::with('nasabah', 'petugas')->latest('created_at')->paginate(15);
        $petugasList = User::whereIn('role', ['staf_administrasi', 'superadmin'])->get();

        return view('admin.jemput_index', compact('jemputList', 'petugasList'));
    }

    public function jemputUpdateStatus(Request $request, $id_permohonan_jemput)
    {
        $jemput = PermohonanJemput::findOrFail($id_permohonan_jemput);

        $validated = $request->validate([
            'status_jemput' => ['required', 'in:menunggu,dijadwalkan,sedang_dijemput,selesai,dibatalkan'],
            'id_petugas' => ['nullable', 'exists:users,id_user'],
            'catatan_petugas' => ['nullable', 'string'],
        ]);

        $jemput->update([
            'status_jemput' => $validated['status_jemput'],
            'id_petugas' => $validated['id_petugas'] ?? $jemput->id_petugas ?? Auth::id(),
            'catatan_petugas' => $validated['catatan_petugas'] ?? $jemput->catatan_petugas,
        ]);

        return back()->with('success', 'Status permohonan jemput Bentor berhasil diperbarui menjadi: ' . strtoupper(str_replace('_', ' ', $validated['status_jemput'])));
    }

    /**
     * Master Komoditas Sampah & Harga
     */
    public function hargaSampahIndex()
    {
        $kategoriList = KategoriSampah::all();
        $sampahList = Sampah::with('kategori')->orderBy('nama_sampah')->paginate(15);

        return view('admin.harga_sampah_index', compact('kategoriList', 'sampahList'));
    }

    public function hargaSampahUpdate(Request $request, $id_sampah)
    {
        $sampah = Sampah::findOrFail($id_sampah);

        $validated = $request->validate([
            'harga_beli_nasabah' => ['required', 'numeric', 'min:0'],
            'harga_jual_pengepul' => ['required', 'numeric', 'min:0'],
            'is_aktif' => ['required', 'boolean'],
        ]);

        $sampah->update($validated);

        return back()->with('success', 'Harga komoditas ' . $sampah->nama_sampah . ' berhasil diperbarui!');
    }

    /**
     * Transit Limbah Medis Rumah Sakit (B2B)
     */
    public function transitLimbahIndex()
    {
        $transitList = TransitLimbahMedis::with('petugas')->latest('waktu_masuk_depo')->paginate(10);
        return view('admin.transit_limbah_index', compact('transitList'));
    }

    public function transitLimbahStore(Request $request)
    {
        $validated = $request->validate([
            'nomor_manifest' => ['required', 'string', 'unique:transit_limbah_medis,nomor_manifest'],
            'rumah_sakit_asal' => ['required', 'string', 'max:150'],
            'pengelola_utama_tujuan' => ['required', 'string', 'max:150'],
            'jenis_limbah' => ['required', 'string', 'max:100'],
            'berat_kg' => ['required', 'numeric', 'min:0.5'],
            'waktu_masuk_depo' => ['required', 'date'],
            'catatan' => ['nullable', 'string'],
        ]);

        TransitLimbahMedis::create([
            'nomor_manifest' => $validated['nomor_manifest'],
            'id_petugas' => Auth::id(),
            'rumah_sakit_asal' => $validated['rumah_sakit_asal'],
            'pengelola_utama_tujuan' => $validated['pengelola_utama_tujuan'],
            'jenis_limbah' => $validated['jenis_limbah'],
            'berat_kg' => $validated['berat_kg'],
            'waktu_masuk_depo' => $validated['waktu_masuk_depo'],
            'status_transit' => 'berada_di_depo',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return back()->with('success', 'Pencatatan manifes transit limbah RS berhasil disimpan.');
    }

    /**
     * Penjualan Sampah Press ke Pengepul / Pabrik
     */
    public function penjualanPengepulIndex()
    {
        $sampahList = Sampah::all();
        $penjualanList = PenjualanPengepul::with(['admin', 'details.sampah'])->latest('tanggal_penjualan')->paginate(10);

        return view('admin.penjualan_pengepul_index', compact('sampahList', 'penjualanList'));
    }

    public function penjualanPengepulStore(Request $request)
    {
        $validated = $request->validate([
            'nama_pabrik_pengepul' => ['required', 'string', 'max:150'],
            'tanggal_penjualan' => ['required', 'date'],
            'id_sampah' => ['required', 'exists:sampah,id_sampah'],
            'berat_jual' => ['required', 'numeric', 'min:1'],
            'harga_jual_satuan' => ['required', 'numeric', 'min:1'],
            'catatan' => ['nullable', 'string'],
        ]);

        $subtotal = $validated['berat_jual'] * $validated['harga_jual_satuan'];
        $kodePenjualan = 'SLS-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        DB::transaction(function () use ($validated, $subtotal, $kodePenjualan) {
            $penjualan = PenjualanPengepul::create([
                'kode_penjualan' => $kodePenjualan,
                'id_admin' => Auth::id(),
                'nama_pabrik_pengepul' => $validated['nama_pabrik_pengepul'],
                'tanggal_penjualan' => $validated['tanggal_penjualan'],
                'total_berat' => $validated['berat_jual'],
                'total_pendapatan' => $subtotal,
                'status_pembayaran' => 'lunas',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            DetailPenjualanPengepul::create([
                'id_penjualan_pengepul' => $penjualan->id_penjualan_pengepul,
                'id_sampah' => $validated['id_sampah'],
                'berat_satuan' => $validated['berat_jual'],
                'harga_jual_satuan' => $validated['harga_jual_satuan'],
                'subtotal' => $subtotal,
            ]);
        });

        return back()->with('success', 'Penjualan sampah ke pabrik/pengepul berhasil dicatat! Pendapatan kas masuk: Rp ' . number_format($subtotal, 0, ',', '.'));
    }

    /**
     * Cetak Struk / Nota Timbangan Digital Thermal (PDF / Print View)
     */
    public function cetakNota($id_transaksi_setor)
    {
        $transaksi = TransaksiSetor::with(['nasabah', 'petugas', 'details.sampah.kategori'])->findOrFail($id_transaksi_setor);
        return view('shared.nota_timbangan', compact('transaksi'));
    }

    /**
     * ========================================================
     * MANAJEMEN BERITA & EDUKASI MASYARAKAT
     * ========================================================
     */
    public function beritaIndex()
    {
        $beritaList = BeritaEdukasi::with('penulis')
            ->latest('created_at')
            ->paginate(10);

        return view('admin.berita_index', compact('beritaList'));
    }

    public function beritaCreate()
    {
        return view('admin.berita_form', [
            'isEdit' => false,
            'berita' => new BeritaEdukasi(),
        ]);
    }

    public function beritaStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'kategori' => ['required', 'in:edukasi,kegiatan,pengumuman'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'judul.required' => 'Judul artikel wajib diisi.',
            'konten.required' => 'Konten / isi artikel edukasi wajib diisi.',
        ]);

        $slugBase = Str::slug($validated['judul']);
        $slug = $slugBase;
        $counter = 1;
        while (BeritaEdukasi::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter++;
        }

        // Auto ringkasan jika kosong
        $ringkasan = !empty($validated['ringkasan'])
            ? $validated['ringkasan']
            : Str::limit(strip_tags($validated['konten']), 160);

        BeritaEdukasi::create([
            'id_user' => Auth::id(),
            'judul' => $validated['judul'],
            'slug' => $slug,
            'kategori' => $validated['kategori'],
            'ringkasan' => $ringkasan,
            'konten' => $validated['konten'],
            'is_published' => $request->has('is_published'),
            'dilihat' => 0,
        ]);

        return redirect()->route('admin.berita')->with('success', 'Artikel edukasi berhasil diterbitkan!');
    }

    public function beritaEdit($id_berita)
    {
        $berita = BeritaEdukasi::findOrFail($id_berita);
        return view('admin.berita_form', [
            'isEdit' => true,
            'berita' => $berita,
        ]);
    }

    public function beritaUpdate(Request $request, $id_berita)
    {
        $berita = BeritaEdukasi::findOrFail($id_berita);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'kategori' => ['required', 'in:edukasi,kegiatan,pengumuman'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($berita->judul !== $validated['judul']) {
            $slugBase = Str::slug($validated['judul']);
            $slug = $slugBase;
            $counter = 1;
            while (BeritaEdukasi::where('slug', $slug)->where('id_berita', '!=', $berita->id_berita)->exists()) {
                $slug = $slugBase . '-' . $counter++;
            }
            $berita->slug = $slug;
        }

        $ringkasan = !empty($validated['ringkasan'])
            ? $validated['ringkasan']
            : Str::limit(strip_tags($validated['konten']), 160);

        $berita->update([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'ringkasan' => $ringkasan,
            'konten' => $validated['konten'],
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.berita')->with('success', 'Artikel edukasi berhasil diperbarui!');
    }

    public function beritaDestroy($id_berita)
    {
        $berita = BeritaEdukasi::findOrFail($id_berita);
        $berita->delete();

        return redirect()->route('admin.berita')->with('success', 'Artikel edukasi telah dihapus.');
    }
}

