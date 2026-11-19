<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaEdukasi extends Model
{
    use HasFactory;

    protected $table = 'berita_edukasi';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'id_user',
        'judul',
        'slug',
        'kategori',
        'ringkasan',
        'konten',
        'gambar_sampul_path',
        'is_published',
        'dilihat',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'dilihat' => 'integer',
        ];
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

