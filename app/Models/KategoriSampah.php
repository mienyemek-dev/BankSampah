<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSampah extends Model
{
    use HasFactory;

    protected $table = 'kategori_sampah';
    protected $primaryKey = 'id_kategori_sampah';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    public function sampah()
    {
        return $this->hasMany(Sampah::class, 'id_kategori_sampah', 'id_kategori_sampah');
    }
}

