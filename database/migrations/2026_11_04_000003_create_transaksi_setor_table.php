<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_setor', function (Blueprint $table) {
            $table->id('id_transaksi_setor');
            $table->string('kode_transaksi', 50)->unique();
            $table->unsignedBigInteger('id_user'); // Nasabah
            $table->unsignedBigInteger('id_petugas'); // Staf penimbang
            $table->dateTime('tanggal_setor');
            $table->decimal('total_berat', 10, 2)->default(0.00);
            $table->decimal('total_nominal', 15, 2)->default(0.00);
            $table->enum('metode_setor', ['antar_sendiri', 'jemput_bentor'])->default('antar_sendiri');
            $table->enum('status_setor', ['selesai', 'dibatalkan'])->default('selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('id_petugas')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_setor');
    }
};

