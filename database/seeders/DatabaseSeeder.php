<?php

namespace Database\Seeders;

use App\Models\BeritaEdukasi;
use App\Models\KategoriSampah;
use App\Models\LokasiOperasional;
use App\Models\ProdukOlahan;
use App\Models\Sampah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna (Multi-Role)
        $superadmin = User::create([
            'nama_lengkap' => 'Bapak Hidayat (Pimpinan)',
            'email' => 'pimpinan@saiwawai.id',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'status_akun' => 'aktif',
            'no_hp' => '085379324445',
            'alamat_lengkap' => 'Desa Banjar Rejo, Kec. Batanghari, Kab. Lampung Timur',
            'desa' => 'Banjar Rejo',
            'kecamatan' => 'Batanghari',
        ]);

        $stafAdmin = User::create([
            'nama_lengkap' => 'Staf Administrasi & Timbangan',
            'email' => 'admin@saiwawai.id',
            'password' => Hash::make('password123'),
            'role' => 'staf_administrasi',
            'status_akun' => 'aktif',
            'no_hp' => '081234567891',
            'alamat_lengkap' => 'Kantor Bank Sampah Bumi Sai Wawai',
            'desa' => 'Banjar Rejo',
            'kecamatan' => 'Batanghari',
        ]);

        $adminKeuangan = User::create([
            'nama_lengkap' => 'Bendahara & Admin Keuangan',
            'email' => 'keuangan@saiwawai.id',
            'password' => Hash::make('password123'),
            'role' => 'admin_keuangan',
            'status_akun' => 'aktif',
            'no_hp' => '081234567892',
            'alamat_lengkap' => 'Desa Banjar Rejo',
            'desa' => 'Banjar Rejo',
            'kecamatan' => 'Batanghari',
        ]);

        $nasabah1 = User::create([
            'nama_lengkap' => 'Wahyu Syahputra',
            'email' => 'nasabah@saiwawai.id',
            'password' => Hash::make('password123'),
            'role' => 'nasabah',
            'status_akun' => 'aktif',
            'no_hp' => '081234567890',
            'nik' => '1807011234560001',
            'tempat_lahir' => 'Metro',
            'tanggal_lahir' => '2001-11-12',
            'jenis_kelamin' => 'laki-laki',
            'rt' => '01',
            'rw' => '02',
            'desa' => 'Banjar Rejo',
            'kecamatan' => 'Batanghari',
            'alamat_lengkap' => 'RT 01 / RW 02, Desa Banjar Rejo, Batanghari',
            'saldo' => 50000.00,
            'total_berat_sampah' => 15.50,
        ]);

        // 2. Kategori Sampah
        $katPlastik = KategoriSampah::create([
            'nama_kategori' => 'Sampah Plastik',
            'slug' => 'sampah-plastik',
            'deskripsi' => 'Botol PET bening, gelas mineral, ember plastik, kresek bersih, dan jenis plastik lainnya.',
        ]);

        $katKertas = KategoriSampah::create([
            'nama_kategori' => 'Kertas & Karton',
            'slug' => 'kertas-dan-karton',
            'deskripsi' => 'Kardus coklat, kertas HVS putih bekas, koran, majalah, dan dupleks.',
        ]);

        $katLogam = KategoriSampah::create([
            'nama_kategori' => 'Logam & Kaleng',
            'slug' => 'logam-dan-kaleng',
            'deskripsi' => 'Besi tebal, kaleng minuman aluminium, seng, dan tembaga.',
        ]);

        $katMinyak = KategoriSampah::create([
            'nama_kategori' => 'Minyak Jelantah',
            'slug' => 'minyak-jelantah',
            'deskripsi' => 'Limbah minyak goreng bekas pakai rumah tangga yang sudah disaring dari remah makanan.',
        ]);

        $katOrganik = KategoriSampah::create([
            'nama_kategori' => 'Sampah Organik Rumah Tangga',
            'slug' => 'sampah-organik',
            'deskripsi' => 'Sisa sayuran, buah-buahan, dan sisa bahan dapur untuk bahan baku pupuk kompos.',
        ]);

        // 3. Master Komoditas Sampah & Harga
        Sampah::create([
            'id_kategori_sampah' => $katPlastik->id_kategori_sampah,
            'nama_sampah' => 'Botol Plastik PET Bening Bersih',
            'satuan' => 'kg',
            'harga_beli_nasabah' => 3500.00,
            'harga_jual_pengepul' => 5000.00,
            'deskripsi' => 'Botol air mineral transparan tanpa tutup dan label.',
        ]);

        Sampah::create([
            'id_kategori_sampah' => $katPlastik->id_kategori_sampah,
            'nama_sampah' => 'Gelas Plastik Bersih (PP)',
            'satuan' => 'kg',
            'harga_beli_nasabah' => 2500.00,
            'harga_jual_pengepul' => 4000.00,
            'deskripsi' => 'Gelas plastik minuman bersih tanpa sablon.',
        ]);

        Sampah::create([
            'id_kategori_sampah' => $katKertas->id_kategori_sampah,
            'nama_sampah' => 'Kardus Bekas Kering',
            'satuan' => 'kg',
            'harga_beli_nasabah' => 2000.00,
            'harga_jual_pengepul' => 3000.00,
            'deskripsi' => 'Kardus cokelat tebal dalam kondisi kering tidak terkena minyak/air.',
        ]);

        Sampah::create([
            'id_kategori_sampah' => $katKertas->id_kategori_sampah,
            'nama_sampah' => 'Kertas Arsip / HVS Putih',
            'satuan' => 'kg',
            'harga_beli_nasabah' => 2200.00,
            'harga_jual_pengepul' => 3200.00,
            'deskripsi' => 'Kertas dokumen HVS putih tanpa staples.',
        ]);

        Sampah::create([
            'id_kategori_sampah' => $katLogam->id_kategori_sampah,
            'nama_sampah' => 'Kaleng Minuman Aluminium',
            'satuan' => 'kg',
            'harga_beli_nasabah' => 12000.00,
            'harga_jual_pengepul' => 16000.00,
            'deskripsi' => 'Kaleng minuman bersoda aluminium pipih.',
        ]);

        Sampah::create([
            'id_kategori_sampah' => $katLogam->id_kategori_sampah,
            'nama_sampah' => 'Besi Padu / Scrap',
            'satuan' => 'kg',
            'harga_beli_nasabah' => 4000.00,
            'harga_jual_pengepul' => 6000.00,
            'deskripsi' => 'Potongan besi tua dan rongsok logam berat.',
        ]);

        Sampah::create([
            'id_kategori_sampah' => $katMinyak->id_kategori_sampah,
            'nama_sampah' => 'Minyak Goreng Bekas (Jelantah)',
            'satuan' => 'liter',
            'harga_beli_nasabah' => 6500.00,
            'harga_jual_pengepul' => 9000.00,
            'deskripsi' => 'Minyak jelantah cair dalam wadah jerigen/botol bersih.',
        ]);

        Sampah::create([
            'id_kategori_sampah' => $katOrganik->id_kategori_sampah,
            'nama_sampah' => 'Sampah Organik Terpilah',
            'satuan' => 'kg',
            'harga_beli_nasabah' => 500.00,
            'harga_jual_pengepul' => 1500.00,
            'deskripsi' => 'Sisa sayur/buah segar dapur untuk bahan baku fermentasi kompos.',
        ]);

        // 4. Produk Olahan (Pupuk Organik & Minyak Jelantah)
        ProdukOlahan::create([
            'nama_produk' => 'Pupuk Kompos Organik Super (5 Kg)',
            'slug' => 'pupuk-kompos-organik-super-5kg',
            'kategori' => 'pupuk_organik',
            'satuan' => 'sak 5kg',
            'stok' => 85,
            'harga_rupiah' => 20000.00,
            'bisa_tukar_saldo' => true,
            'deskripsi' => 'Pupuk kompos hasil dekomposisi sampah organik rumah tangga binaan Bank Sampah Bumi Sai Wawai. Sangat subur untuk tanaman hias, sayuran, dan perkebunan.',
        ]);

        ProdukOlahan::create([
            'nama_produk' => 'Pupuk Organik Cair (POC) Bio-Fermentasi (1 Liter)',
            'slug' => 'poc-bio-fermentasi-1l',
            'kategori' => 'pupuk_organik',
            'satuan' => 'botol 1L',
            'stok' => 40,
            'harga_rupiah' => 15000.00,
            'bisa_tukar_saldo' => true,
            'deskripsi' => 'Pupuk cair kaya mikroorganisme baik untuk menyuburkan tanah dan merangsang pembungaan buah.',
        ]);

        ProdukOlahan::create([
            'nama_produk' => 'Lilin Aromaterapi Daur Ulang Minyak Jelantah',
            'slug' => 'lilin-aromaterapi-jelantah',
            'kategori' => 'kerajinan_daur_ulang',
            'satuan' => 'pcs',
            'stok' => 25,
            'harga_rupiah' => 10000.00,
            'bisa_tukar_saldo' => true,
            'deskripsi' => 'Kerajinan lilin aromaterapi wangi lavender hasil pemurnian minyak jelantah ramah lingkungan.',
        ]);

        // 5. Berita & Edukasi
        BeritaEdukasi::create([
            'id_user' => $superadmin->id_user,
            'judul' => 'Mengenal Bank Sampah Bumi Sai Wawai: Dari Sampah Menjadi Berkah',
            'slug' => 'mengenal-bank-sampah-bumi-sai-wawai',
            'kategori' => 'kegiatan',
            'ringkasan' => 'Bank Sampah Bumi Sai Wawai di Banjar Rejo hadir untuk membangun kepedulian lingkungan dan memberikan nilai ekonomi nyata bagi masyarakat.',
            'konten' => 'Berdiri sejak tahun 2021 di bawah kepemimpinan Bapak Hidayat, Bank Sampah Bumi Sai Wawai terus bergerak mengajak warga mengelola sampah dengan baik sesuai anjuran Al-Quran Surat Ar-Rum ayat 41-42...',
            'gambar_sampul_path' => 'images/articles/profil-bank-sampah.webp',
            'is_published' => true,
            'dilihat' => 45,
        ]);

        BeritaEdukasi::create([
            'id_user' => $stafAdmin->id_user,
            'judul' => 'Panduan Mudah Memilah Sampah Rumah Tangga Sebelum Disetor',
            'slug' => 'panduan-memilah-sampah-rumah-tangga',
            'kategori' => 'edukasi',
            'ringkasan' => 'Tips sederhana memisahkan sampah plastik, kardus, dan minyak jelantah agar memiliki nilai jual tinggi saat ditimbang.',
            'konten' => 'Agar sampah yang Anda setorkan mendapatkan nilai timbangan maksimal, pastikan botol plastik dalam kondisi kering dan dipipihkan. Kardus diikat rapi, serta minyak jelantah disaring terlebih dahulu...',
            'gambar_sampul_path' => 'images/articles/panduan-memilah-sampah.webp',
            'is_published' => true,
            'dilihat' => 68,
        ]);

        BeritaEdukasi::create([
            'id_user' => $superadmin->id_user,
            'judul' => 'Kini Saldo Tabungan Sampah Bisa Langsung Dicairkan ke E-Wallet (DANA, GoPay & OVO)!',
            'slug' => 'pencairan-tabungan-sampah-ke-ewallet',
            'kategori' => 'pengumuman',
            'ringkasan' => 'Warga Banjar Rejo kini semakin praktis menikmati hasil tabungan sampah. Tanpa repot rekening bank konvensional, saldo tabungan bisa langsung ditarik ke dompet digital tanpa potongan biaya admin.',
            'konten' => "Kabar gembira bagi seluruh nasabah Bank Sampah Bumi Sai Wawai! Dalam rangka mempermudah transaksi mikro dan memperluas inklusi keuangan digital di Desa Banjar Rejo, kini sistem penarikan saldo tabungan sampah telah terintegrasi langsung dengan berbagai layanan Dompet Digital (E-Wallet) terkemuka di Indonesia.\n\nNasabah kini dapat mencairkan saldo hasil penimbangan sampah kapan saja langsung ke akun DANA, GoPay, OVO, ShopeePay, hingga LinkAja hanya dengan memasukkan nomor handphone yang terdaftar.\n\nKeunggulan Penarikan Saldo ke E-Wallet:\n1. Bebas Biaya Admin: Pengurus bank sampah memastikan penarikan saldo tidak dikenakan potongan biaya transfer perbankan.\n2. Praktis untuk Nominal Mikro: Sangat cocok untuk nominal tabungan harian/mingguan seperti Rp 20.000, Rp 50.000, atau Rp 100.000 tanpa harus antre di mesin ATM.\n3. Saldo Cepat Masuk: Begitu diverifikasi oleh admin keuangan, saldo langsung masuk ke dompet digital nasabah dan siap dibelanjakan untuk kebutuhan dapur, pulsa, atau token listrik.\n4. Tanpa Perlu Rekening Bank: Menjawab kebutuhan warga dan saran akademis bahwa transaksi bank sampah desa lebih efektif difokuskan pada dompet digital yang sudah akrab di smartphone warga.\n\nAyo terus pilah sampah dari rumah, setorkan ke Depo Banjar Rejo atau panggil armada bentor kami, dan nikmati tabungan berkah langsung di genggaman Anda!",
            'gambar_sampul_path' => 'images/articles/pencairan-ewallet.webp',
            'is_published' => true,
            'dilihat' => 124,
        ]);

        // 6. Lokasi Operasional
        LokasiOperasional::create([
            'nama_lokasi' => 'Depo Pusat Bank Sampah Bumi Sai Wawai',
            'alamat_lengkap' => 'Jl. Poros Desa Banjar Rejo, Kec. Batanghari, Kab. Lampung Timur, Lampung',
            'latitude' => -5.0567210,
            'longitude' => 105.3421500,
            'jam_operasional' => 'Senin - Sabtu: 08.00 - 16.00 WIB',
            'no_kontak' => '085379324445',
            'keterangan' => 'Pusat penimbangan, mesin press sampah, pengolahan pupuk organik, dan pangkalan armada bentor.',
        ]);
    }
}
