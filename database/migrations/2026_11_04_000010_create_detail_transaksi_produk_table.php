<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi_produk', function (Blueprint $table) {
            $table->id('id_detail_produk');
            $table->unsignedBigInteger('id_transaksi_produk');
            $table->unsignedBigInteger('id_produk');
            $table->integer('jumlah');
            $table->decimal('harga_saat_transaksi', 12, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('id_transaksi_produk')
                  ->references('id_transaksi_produk')
                  ->on('transaksi_produk')
                  ->onDelete('cascade');

            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk_olahan')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_produk');
    }
};

