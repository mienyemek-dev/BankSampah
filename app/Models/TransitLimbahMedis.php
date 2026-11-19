<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransitLimbahMedis extends Model
{
    use HasFactory;

    protected $table = 'transit_limbah_medis';
    protected $primaryKey = 'id_transit_limbah';

    protected $fillable = [
        'nomor_manifest',
        'id_petugas',
        'rumah_sakit_asal',
        'pengelola_utama_tujuan',
        'jenis_limbah',
        'berat_kg',
        'waktu_masuk_depo',
        'waktu_diambil_pengelola',
        'status_transit',
        'dokumen_manifest_path',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'berat_kg' => 'decimal:2',
            'waktu_masuk_depo' => 'datetime',
            'waktu_diambil_pengelola' => 'datetime',
        ];
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id_user');
    }
}

