<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penarikan_saldo', function (Blueprint $table) {
            $table->id('id_penarikan');
            $table->string('kode_penarikan', 50)->unique();
            $table->unsignedBigInteger('id_user'); // Nasabah pemohon
            $table->unsignedBigInteger('id_admin')->nullable(); // Admin keuangan yang menyetujui/mentransfer
            $table->decimal('nominal_penarikan', 15, 2);
            $table->decimal('biaya_admin', 10, 2)->default(0.00);
            $table->decimal('total_diterima', 15, 2);
            $table->enum('metode_pencairan', ['transfer_bank', 'ewallet', 'tunai'])->default('transfer_bank');
            $table->string('nama_bank', 100);
            $table->string('nomor_rekening', 50);
            $table->string('atas_nama', 150);
            $table->enum('status_penarikan', ['diajukan', 'diproses', 'selesai', 'ditolak'])->default('diajukan');
            $table->string('bukti_transfer_path')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->dateTime('tanggal_pengajuan');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('id_admin')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penarikan_saldo');
    }
};

