<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->string('kode_invoice', 50)->unique();
            $table->unsignedBigInteger('id_transaksi_produk');
            $table->unsignedBigInteger('id_user');
            $table->enum('metode_pembayaran', ['qris', 'va_bca', 'va_bri', 'va_mandiri', 'va_bni', 'gopay', 'dana', 'saldo_tabungan'])->default('qris');
            $table->string('nomor_va_atau_paycode', 50)->nullable();
            $table->decimal('nominal', 15, 2);
            $table->enum('status_pembayaran', ['menunggu', 'lunas', 'kedaluwarsa', 'batal'])->default('menunggu');
            $table->dateTime('waktu_transaksi');
            $table->dateTime('waktu_lunas')->nullable();
            $table->dateTime('waktu_kedaluwarsa');
            $table->string('simulasi_bank_ref', 100)->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi_produk')
                  ->references('id_transaksi_produk')
                  ->on('transaksi_produk')
                  ->onDelete('cascade');

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

