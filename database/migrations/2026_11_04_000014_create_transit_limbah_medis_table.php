<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transit_limbah_medis', function (Blueprint $table) {
            $table->id('id_transit_limbah');
            $table->string('nomor_manifest', 80)->unique();
            $table->unsignedBigInteger('id_petugas'); // Petugas penerima
            $table->string('rumah_sakit_asal', 150);
            $table->string('pengelola_utama_tujuan', 150); // Vendor B3
            $table->string('jenis_limbah', 100); // Medis padat, botol infus, jarum, dsb
            $table->decimal('berat_kg', 10, 2);
            $table->dateTime('waktu_masuk_depo');
            $table->dateTime('waktu_diambil_pengelola')->nullable();
            $table->enum('status_transit', ['berada_di_depo', 'telah_diserahterimakan'])->default('berada_di_depo');
            $table->string('dokumen_manifest_path')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_petugas')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transit_limbah_medis');
    }
};

