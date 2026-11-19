<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_pengepul', function (Blueprint $table) {
            $table->id('id_penjualan_pengepul');
            $table->string('kode_penjualan', 50)->unique();
            $table->unsignedBigInteger('id_admin'); // Admin pengelola
            $table->string('nama_pabrik_pengepul', 150);
            $table->date('tanggal_penjualan');
            $table->decimal('total_berat', 12, 2)->default(0.00);
            $table->decimal('total_pendapatan', 15, 2)->default(0.00);
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas'])->default('lunas');
            $table->string('bukti_timbangan_nota_path')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_admin')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_pengepul');
    }
};

