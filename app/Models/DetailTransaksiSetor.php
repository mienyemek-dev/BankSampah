<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiSetor extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_setor';
    protected $primaryKey = 'id_detail_setor';

    protected $fillable = [
        'id_transaksi_setor',
        'id_sampah',
        'jumlah_satuan',
        'harga_saat_transaksi',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_satuan' => 'decimal:2',
            'harga_saat_transaksi' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiSetor::class, 'id_transaksi_setor', 'id_transaksi_setor');
    }

    public function sampah()
    {
        return $this->belongsTo(Sampah::class, 'id_sampah', 'id_sampah');
    }
}

