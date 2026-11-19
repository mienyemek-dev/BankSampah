<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiSaldo extends Model
{
    use HasFactory;

    protected $table = 'mutasi_saldo';
    protected $primaryKey = 'id_mutasi';

    protected $fillable = [
        'id_user',
        'jenis_mutasi',
        'jumlah',
        'saldo_sebelum',
        'saldo_sesudah',
        'kategori_transaksi',
        'referensi_kode',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'saldo_sebelum' => 'decimal:2',
            'saldo_sesudah' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

