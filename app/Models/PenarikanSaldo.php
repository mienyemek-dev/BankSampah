<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanSaldo extends Model
{
    use HasFactory;

    protected $table = 'penarikan_saldo';
    protected $primaryKey = 'id_penarikan';

    protected $fillable = [
        'kode_penarikan',
        'id_user',
        'id_admin',
        'nominal_penarikan',
        'biaya_admin',
        'total_diterima',
        'metode_pencairan',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'status_penarikan',
        'bukti_transfer_path',
        'catatan_admin',
        'tanggal_pengajuan',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'nominal_penarikan' => 'decimal:2',
            'biaya_admin' => 'decimal:2',
            'total_diterima' => 'decimal:2',
            'tanggal_pengajuan' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function nasabah()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }
}

