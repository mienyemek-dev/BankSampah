<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi_setor', function (Blueprint $table) {
            $table->id('id_detail_setor');
            $table->unsignedBigInteger('id_transaksi_setor');
            $table->unsignedBigInteger('id_sampah');
            $table->decimal('jumlah_satuan', 10, 2); // Berat (kg) atau Volume (liter)
            $table->decimal('harga_saat_transaksi', 12, 2); // Snapshot harga agar transaksi masa lalu tidak berubah
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('id_transaksi_setor')
                  ->references('id_transaksi_setor')
                  ->on('transaksi_setor')
                  ->onDelete('cascade');

            $table->foreign('id_sampah')
                  ->references('id_sampah')
                  ->on('sampah')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_setor');
    }
};

