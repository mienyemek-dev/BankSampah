<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'kode_invoice',
        'id_transaksi_produk',
        'id_user',
        'metode_pembayaran',
        'nomor_va_atau_paycode',
        'nominal',
        'status_pembayaran',
        'waktu_transaksi',
        'waktu_lunas',
        'waktu_kedaluwarsa',
        'simulasi_bank_ref',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'waktu_transaksi' => 'datetime',
            'waktu_lunas' => 'datetime',
            'waktu_kedaluwarsa' => 'datetime',
        ];
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiProduk::class, 'id_transaksi_produk', 'id_transaksi_produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

