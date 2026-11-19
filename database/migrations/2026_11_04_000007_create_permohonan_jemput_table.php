<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_jemput', function (Blueprint $table) {
            $table->id('id_permohonan_jemput');
            $table->string('kode_penjemputan', 50)->unique();
            $table->unsignedBigInteger('id_user'); // Nasabah pemohon
            $table->unsignedBigInteger('id_petugas')->nullable(); // Driver bentor / petugas
            $table->date('tanggal_rencana_jemput');
            $table->string('waktu_preferensi', 50)->nullable(); // Pagi (08:00 - 11:00), Siang (13:00 - 16:00)
            $table->decimal('estimasi_berat', 8, 2); // Minimal 5 kg
            $table->text('alamat_jemput');
            $table->string('patokan_lokasi')->nullable();
            $table->enum('status_jemput', ['menunggu', 'dijadwalkan', 'sedang_dijemput', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->text('catatan_nasabah')->nullable();
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('id_petugas')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_jemput');
    }
};

