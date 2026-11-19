<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiOperasional extends Model
{
    use HasFactory;

    protected $table = 'lokasi_operasional';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'nama_lokasi',
        'alamat_lengkap',
        'latitude',
        'longitude',
        'jam_operasional',
        'no_kontak',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }
}

