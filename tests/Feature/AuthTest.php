<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang');
    }

    public function test_register_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Daftar Nasabah Baru');
    }

    public function test_new_nasabah_can_register_quickly(): void
    {
        $testEmail = 'warga.' . uniqid() . '@example.com';

        $response = $this->post('/register', [
            'nama_lengkap' => 'Warga Percobaan',
            'email' => $testEmail,
            'no_hp' => '089911223344',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('nasabah.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => $testEmail,
            'nama_lengkap' => 'Warga Percobaan',
            'role' => 'nasabah',
            'status_akun' => 'aktif',
        ]);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::where('email', 'nasabah@saiwawai.id')->first();
        if (!$user) {
            $user = User::create([
                'nama_lengkap' => 'Nasabah Test',
                'email' => 'nasabah.test@saiwawai.id',
                'password' => Hash::make('password123'),
                'role' => 'nasabah',
                'status_akun' => 'aktif',
            ]);
        }

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('nasabah.dashboard'));
    }

    public function test_nasabah_cannot_access_admin_dashboard(): void
    {
        $nasabah = User::where('role', 'nasabah')->first();

        $response = $this->actingAs($nasabah)->get('/admin/dashboard');
        $response->assertRedirect(route('dashboard.redirect'));
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::where('role', 'staf_administrasi')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Panel Operasional Administrasi');
    }
}

