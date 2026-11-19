<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_edukasi', function (Blueprint $table) {
            $table->id('id_berita');
            $table->unsignedBigInteger('id_user'); // Penulis
            $table->string('judul', 200);
            $table->string('slug', 230)->unique();
            $table->enum('kategori', ['edukasi', 'kegiatan', 'pengumuman'])->default('edukasi');
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            $table->string('gambar_sampul_path')->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('dilihat')->default(0);
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_edukasi');
    }
};

