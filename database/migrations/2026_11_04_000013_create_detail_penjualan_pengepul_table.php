<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penjualan_pengepul', function (Blueprint $table) {
            $table->id('id_detail_penjualan');
            $table->unsignedBigInteger('id_penjualan_pengepul');
            $table->unsignedBigInteger('id_sampah');
            $table->decimal('berat_satuan', 12, 2);
            $table->decimal('harga_jual_satuan', 12, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('id_penjualan_pengepul')
                  ->references('id_penjualan_pengepul')
                  ->on('penjualan_pengepul')
                  ->onDelete('cascade');

            $table->foreign('id_sampah')
                  ->references('id_sampah')
                  ->on('sampah')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan_pengepul');
    }
};

