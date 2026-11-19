<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiProduk extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_produk';
    protected $primaryKey = 'id_detail_produk';

    protected $fillable = [
        'id_transaksi_produk',
        'id_produk',
        'jumlah',
        'harga_saat_transaksi',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'harga_saat_transaksi' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiProduk::class, 'id_transaksi_produk', 'id_transaksi_produk');
    }

    public function produk()
    {
        return $this->belongsTo(ProdukOlahan::class, 'id_produk', 'id_produk');
    }
}

