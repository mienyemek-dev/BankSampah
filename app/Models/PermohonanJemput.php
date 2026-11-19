<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanJemput extends Model
{
    use HasFactory;

    protected $table = 'permohonan_jemput';
    protected $primaryKey = 'id_permohonan_jemput';

    protected $fillable = [
        'kode_penjemputan',
        'id_user',
        'id_petugas',
        'tanggal_rencana_jemput',
        'waktu_preferensi',
        'estimasi_berat',
        'alamat_jemput',
        'patokan_lokasi',
        'status_jemput',
        'catatan_nasabah',
        'catatan_petugas',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_rencana_jemput' => 'date',
            'estimasi_berat' => 'decimal:2',
        ];
    }

    public function nasabah()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id_user');
    }
}

