<?php

namespace Tests\Feature;

use App\Models\BeritaEdukasi;
use App\Models\TransaksiSetor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SistemBankSampahTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Uji halaman publik / landing page dapat diakses tanpa login
     */
    public function test_landing_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Bank Sampah');
        $response->assertSee('Bumi Sai Wawai');
    }

    /**
     * Uji detail artikel edukasi dapat diakses oleh publik
     */
    public function test_detail_artikel_can_be_rendered(): void
    {
        $artikel = BeritaEdukasi::first();
        if ($artikel) {
            $response = $this->get('/artikel/' . $artikel->slug);
            $response->assertStatus(200);
            $response->assertSee($artikel->judul);
        } else {
            $this->assertTrue(true);
        }
    }

    /**
     * Uji pimpinan (superadmin) dapat mengakses dashboard eksekutif
     */
    public function test_superadmin_can_access_pimpinan_dashboard(): void
    {
        $pimpinan = User::where('role', 'superadmin')->first();
        if (!$pimpinan) {
            $pimpinan = User::factory()->create([
                'role' => 'superadmin',
                'status_akun' => 'aktif',
            ]);
        }

        $response = $this->actingAs($pimpinan)->get('/pimpinan/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Ringkasan Kinerja Eksekutif');
    }

    /**
     * Uji nasabah biasa TIDAK bisa mengakses dashboard eksekutif pimpinan
     */
    public function test_nasabah_cannot_access_pimpinan_dashboard(): void
    {
        $nasabah = User::where('role', 'nasabah')->first();

        $response = $this->actingAs($nasabah)->get('/pimpinan/dashboard');
        $response->assertRedirect(route('dashboard.redirect'));
    }

    /**
     * Uji cetak nota timbangan oleh admin
     */
    public function test_admin_can_view_nota_timbangan(): void
    {
        $admin = User::where('role', 'staf_administrasi')->first();
        $transaksi = TransaksiSetor::first();

        if ($transaksi && $admin) {
            $response = $this->actingAs($admin)->get('/admin/nota/' . $transaksi->id_transaksi_setor);
            $response->assertStatus(200);
            $response->assertSee($transaksi->kode_transaksi);
            $response->assertSee('BANK SAMPAH');
        } else {
            $this->assertTrue(true);
        }
    }
}
