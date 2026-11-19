<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    use HasFactory;

    protected $table = 'sampah';
    protected $primaryKey = 'id_sampah';

    protected $fillable = [
        'id_kategori_sampah',
        'nama_sampah',
        'satuan',
        'harga_beli_nasabah',
        'harga_jual_pengepul',
        'deskripsi',
        'gambar_path',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga_beli_nasabah' => 'decimal:2',
            'harga_jual_pengepul' => 'decimal:2',
            'is_aktif' => 'boolean',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSampah::class, 'id_kategori_sampah', 'id_kategori_sampah');
    }

    public function detailSetor()
    {
        return $this->hasMany(DetailTransaksiSetor::class, 'id_sampah', 'id_sampah');
    }
}

