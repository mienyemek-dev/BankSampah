<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_saldo', function (Blueprint $table) {
            $table->id('id_mutasi');
            $table->unsignedBigInteger('id_user');
            $table->enum('jenis_mutasi', ['kredit', 'debit']); // kredit = uang masuk, debit = uang keluar
            $table->decimal('jumlah', 15, 2);
            $table->decimal('saldo_sebelum', 15, 2);
            $table->decimal('saldo_sesudah', 15, 2);
            $table->string('kategori_transaksi', 100); // setor_sampah, penarikan_saldo, beli_produk, hold_penarikan, refund
            $table->string('referensi_kode', 100)->nullable(); // kode transaksi setor atau kode penarikan
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_saldo');
    }
};

