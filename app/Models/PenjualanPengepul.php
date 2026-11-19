<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanPengepul extends Model
{
    use HasFactory;

    protected $table = 'penjualan_pengepul';
    protected $primaryKey = 'id_penjualan_pengepul';

    protected $fillable = [
        'kode_penjualan',
        'id_admin',
        'nama_pabrik_pengepul',
        'tanggal_penjualan',
        'total_berat',
        'total_pendapatan',
        'status_pembayaran',
        'bukti_timbangan_nota_path',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penjualan' => 'date',
            'total_berat' => 'decimal:2',
            'total_pendapatan' => 'decimal:2',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(DetailPenjualanPengepul::class, 'id_penjualan_pengepul', 'id_penjualan_pengepul');
    }
}

