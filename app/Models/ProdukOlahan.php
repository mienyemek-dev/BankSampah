<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukOlahan extends Model
{
    use HasFactory;

    protected $table = 'produk_olahan';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'slug',
        'kategori',
        'satuan',
        'stok',
        'harga_rupiah',
        'bisa_tukar_saldo',
        'deskripsi',
        'gambar_produk_path',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga_rupiah' => 'decimal:2',
            'bisa_tukar_saldo' => 'boolean',
            'is_aktif' => 'boolean',
        ];
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksiProduk::class, 'id_produk', 'id_produk');
    }
}

