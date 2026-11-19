<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSetor extends Model
{
    use HasFactory;

    protected $table = 'transaksi_setor';
    protected $primaryKey = 'id_transaksi_setor';

    protected $fillable = [
        'kode_transaksi',
        'id_user',
        'id_petugas',
        'tanggal_setor',
        'total_berat',
        'total_nominal',
        'metode_setor',
        'status_setor',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_setor' => 'datetime',
            'total_berat' => 'decimal:2',
            'total_nominal' => 'decimal:2',
        ];
    }

    public function nasabah()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksiSetor::class, 'id_transaksi_setor', 'id_transaksi_setor');
    }
}

