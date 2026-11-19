<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sampah', function (Blueprint $table) {
            $table->id('id_sampah');
            $table->unsignedBigInteger('id_kategori_sampah');
            $table->string('nama_sampah', 150);
            $table->enum('satuan', ['kg', 'liter', 'pcs'])->default('kg');
            $table->decimal('harga_beli_nasabah', 12, 2); // Harga bank sampah beli dari nasabah
            $table->decimal('harga_jual_pengepul', 12, 2)->default(0.00); // Estimasi jual ke pabrik
            $table->text('deskripsi')->nullable();
            $table->string('gambar_path')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->foreign('id_kategori_sampah')
                  ->references('id_kategori_sampah')
                  ->on('kategori_sampah')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sampah');
    }
};

