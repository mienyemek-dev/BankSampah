<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC ROUTES (tanpa autentikasi)
// ==========================================
Route::get('/', [PublicController::class, 'landingPage'])->name('home');
Route::get('/artikel/{slug}', [PublicController::class, 'detailArtikel'])->name('artikel.show');

// Guest Routes (Login & Registrasi)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('throttle:3,1');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'redirectByRole'])->name('dashboard.redirect');

    // Profil & Pengaturan Akun
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/ubah-password', [ProfilController::class, 'ubahPassword'])->name('profil.password');

    // ==========================================
    // 1. ROUTE NASABAH
    // ==========================================
    Route::middleware('role:nasabah')->prefix('nasabah')->name('nasabah.')->group(function () {
        Route::get('/dashboard', [NasabahController::class, 'dashboard'])->name('dashboard');

        // Penarikan Saldo
        Route::get('/tarik-saldo', [NasabahController::class, 'tarikSaldoIndex'])->name('tarik_saldo');
        Route::post('/tarik-saldo', [NasabahController::class, 'tarikSaldoStore'])->name('tarik_saldo.store');

        // Minta Jemput Sampah (Bentor)
        Route::get('/jemput-sampah', [NasabahController::class, 'jemputSampahIndex'])->name('jemput_sampah');
        Route::post('/jemput-sampah', [NasabahController::class, 'jemputSampahStore'])->name('jemput_sampah.store');

        // Riwayat Buku Tabungan
        Route::get('/riwayat-tabungan', [NasabahController::class, 'riwayatTabungan'])->name('riwayat_tabungan');

        // Katalog Produk Olahan (Pupuk Organik & Lilin Jelantah)
        Route::get('/katalog-produk', [NasabahController::class, 'katalogProduk'])->name('katalog');
        Route::post('/beli-produk', [NasabahController::class, 'beliProduk'])->name('beli_produk');

        // Virtual Payment Gateway Simulator (Solusi 2 - Mandiri Tanpa Tunnel)
        Route::get('/payment-gateway/{id_pembayaran}', [NasabahController::class, 'paymentSimulator'])->name('payment_simulator');
        Route::post('/payment-gateway/{id_pembayaran}/bayar', [NasabahController::class, 'simulasiBayarSuccess'])->name('simulasi_bayar');

        // Daftar Harga Sampah
        Route::get('/harga-sampah', [NasabahController::class, 'hargaSampah'])->name('harga_sampah');

        // Cetak Resi Setoran Sampah
        Route::get('/nota/{id_transaksi_setor}', [NasabahController::class, 'cetakResi'])->name('nota');
    });

    // ==========================================
    // 2. ROUTE STAF ADMINISTRASI & SUPERADMIN
    // ==========================================
    Route::middleware('role:staf_administrasi,superadmin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Timbang & Setor Sampah
        Route::get('/timbang-sampah', [AdminController::class, 'timbangIndex'])->name('timbang');
        Route::post('/timbang-sampah', [AdminController::class, 'timbangStore'])->name('timbang.store');
        Route::get('/nota/{id_transaksi_setor}', [AdminController::class, 'cetakNota'])->name('nota');

        // Stok & Gudang Depo
        Route::get('/stok-sampah', [AdminController::class, 'stokSampahIndex'])->name('stok_sampah');

        // Manajemen Nasabah
        Route::get('/nasabah', [AdminController::class, 'nasabahIndex'])->name('nasabah');

        // Manajemen Jemput Bentor
        Route::get('/jemput-bentor', [AdminController::class, 'jemputIndex'])->name('jemput');
        Route::post('/jemput-bentor/{id_permohonan_jemput}/update', [AdminController::class, 'jemputUpdateStatus'])->name('jemput.update');

        // Master Harga Sampah
        Route::get('/harga-sampah', [AdminController::class, 'hargaSampahIndex'])->name('harga_sampah');
        Route::post('/harga-sampah/{id_sampah}/update', [AdminController::class, 'hargaSampahUpdate'])->name('harga_sampah.update');

        // Transit Limbah Medis RS
        Route::get('/transit-limbah', [AdminController::class, 'transitLimbahIndex'])->name('transit_limbah');
        Route::post('/transit-limbah', [AdminController::class, 'transitLimbahStore'])->name('transit_limbah.store');

        // Penjualan ke Pengepul / Pabrik
        Route::get('/penjualan-pengepul', [AdminController::class, 'penjualanPengepulIndex'])->name('penjualan_pengepul');
        Route::post('/penjualan-pengepul', [AdminController::class, 'penjualanPengepulStore'])->name('penjualan_pengepul.store');

        // Modul Berita & Edukasi Masyarakat
        Route::get('/berita-edukasi', [AdminController::class, 'beritaIndex'])->name('berita');
        Route::get('/berita-edukasi/create', [AdminController::class, 'beritaCreate'])->name('berita.create');
        Route::post('/berita-edukasi', [AdminController::class, 'beritaStore'])->name('berita.store');
        Route::get('/berita-edukasi/{id_berita}/edit', [AdminController::class, 'beritaEdit'])->name('berita.edit');
        Route::post('/berita-edukasi/{id_berita}/update', [AdminController::class, 'beritaUpdate'])->name('berita.update');
        Route::delete('/berita-edukasi/{id_berita}', [AdminController::class, 'beritaDestroy'])->name('berita.destroy');
    });

    // ==========================================
    // 3. ROUTE ADMIN KEUANGAN & SUPERADMIN
    // ==========================================
    Route::middleware('role:admin_keuangan,superadmin')->prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('/dashboard', [KeuanganController::class, 'dashboard'])->name('dashboard');

        // Permohonan Pencairan Saldo (Payouts)
        Route::get('/penarikan-saldo', [KeuanganController::class, 'penarikanIndex'])->name('penarikan');
        Route::post('/penarikan-saldo/{id_penarikan}/proses', [KeuanganController::class, 'prosesPencairan'])->name('penarikan.proses');

        // Buku Kas & Laporan Finansial
        Route::get('/buku-kas', [KeuanganController::class, 'bukuKas'])->name('buku_kas');
    });

    // ==========================================
    // 4. ROUTE EKSEKUTIF PIMPINAN (SUPERADMIN)
    // ==========================================
    Route::middleware('role:superadmin')->prefix('pimpinan')->name('pimpinan.')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('dashboard');
    });
});
