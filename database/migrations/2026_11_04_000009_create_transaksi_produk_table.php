<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_produk', function (Blueprint $table) {
            $table->id('id_transaksi_produk');
            $table->string('kode_order', 50)->unique();
            $table->unsignedBigInteger('id_user'); // Pembeli / nasabah
            $table->decimal('total_tagihan', 15, 2);
            $table->enum('metode_bayar', ['virtual_gateway', 'saldo_sampah'])->default('virtual_gateway');
            $table->enum('status_order', ['menunggu_pembayaran', 'dibayar', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');
            $table->text('alamat_pengiriman')->nullable();
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_order');
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_produk');
    }
};

