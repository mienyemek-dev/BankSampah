<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'status_akun',
        'alasan_penolakan',
        'no_hp',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'alamat_lengkap',
        'foto_ktp_path',
        'saldo',
        'total_berat_sampah',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'saldo' => 'decimal:2',
            'total_berat_sampah' => 'decimal:2',
        ];
    }

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdminKeuangan(): bool
    {
        return $this->role === 'admin_keuangan';
    }

    public function isStafAdministrasi(): bool
    {
        return $this->role === 'staf_administrasi';
    }

    public function isNasabah(): bool
    {
        return $this->role === 'nasabah';
    }

    public function transaksiSetor()
    {
        return $this->hasMany(TransaksiSetor::class, 'id_user', 'id_user');
    }

    public function penarikanSaldo()
    {
        return $this->hasMany(PenarikanSaldo::class, 'id_user', 'id_user');
    }

    public function mutasiSaldo()
    {
        return $this->hasMany(MutasiSaldo::class, 'id_user', 'id_user');
    }

    public function permohonanJemput()
    {
        return $this->hasMany(PermohonanJemput::class, 'id_user', 'id_user');
    }
}
