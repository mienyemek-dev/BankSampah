<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualanPengepul extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualan_pengepul';
    protected $primaryKey = 'id_detail_penjualan';

    protected $fillable = [
        'id_penjualan_pengepul',
        'id_sampah',
        'berat_satuan',
        'harga_jual_satuan',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'berat_satuan' => 'decimal:2',
            'harga_jual_satuan' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function penjualan()
    {
        return $this->belongsTo(PenjualanPengepul::class, 'id_penjualan_pengepul', 'id_penjualan_pengepul');
    }

    public function sampah()
    {
        return $this->belongsTo(Sampah::class, 'id_sampah', 'id_sampah');
    }
}

