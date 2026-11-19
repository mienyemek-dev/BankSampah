<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiProduk extends Model
{
    use HasFactory;

    protected $table = 'transaksi_produk';
    protected $primaryKey = 'id_transaksi_produk';

    protected $fillable = [
        'kode_order',
        'id_user',
        'total_tagihan',
        'metode_bayar',
        'status_order',
        'alamat_pengiriman',
        'catatan',
        'tanggal_order',
    ];

    protected function casts(): array
    {
        return [
            'total_tagihan' => 'decimal:2',
            'tanggal_order' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksiProduk::class, 'id_transaksi_produk', 'id_transaksi_produk');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi_produk', 'id_transaksi_produk');
    }
}

