<?php

namespace App\Http\Controllers;

use App\Models\BeritaEdukasi;
use App\Models\KategoriSampah;
use App\Models\LokasiOperasional;
use App\Models\ProdukOlahan;
use App\Models\Sampah;
use App\Models\TransaksiSetor;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Halaman utama / landing page publik
     */
    public function landingPage()
    {
        // Statistik ringkas
        $totalNasabah   = User::where('role', 'nasabah')->where('status_akun', 'aktif')->count();
        $totalKgSampah  = TransaksiSetor::where('status_setor', 'selesai')->sum('total_berat');
        $totalTabungan  = User::where('role', 'nasabah')->sum('saldo');

        // Harga sampah (live dari DB)
        $kategoriSampah = KategoriSampah::with(['sampah' => function ($q) {
            $q->where('is_aktif', true)->orderBy('nama_sampah');
        }])->get();

        // Produk olahan (maks 3)
        $produkOlahan = ProdukOlahan::where('stok', '>', 0)->take(6)->get();

        // Berita & edukasi terbaru (maks 3)
        $beritaEdukasi = BeritaEdukasi::where('is_published', true)
            ->latest('created_at')
            ->take(3)
            ->get();

        // Lokasi depo
        $lokasi = LokasiOperasional::first();

        return view('public.landing', compact(
            'totalNasabah',
            'totalKgSampah',
            'totalTabungan',
            'kategoriSampah',
            'produkOlahan',
            'beritaEdukasi',
            'lokasi'
        ));
    }

    /**
     * Detail artikel edukasi
     */
    public function detailArtikel($slug)
    {
        $artikel = BeritaEdukasi::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment pembaca
        $artikel->increment('dilihat');

        $artikelLain = BeritaEdukasi::where('is_published', true)
            ->where('id_berita', '!=', $artikel->id_berita)
            ->latest('created_at')
            ->take(3)
            ->get();

        return view('public.artikel_detail', compact('artikel', 'artikelLain'));
    }
}

