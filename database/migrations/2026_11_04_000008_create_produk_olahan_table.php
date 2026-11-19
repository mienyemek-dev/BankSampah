<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_olahan', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk', 150);
            $table->string('slug', 170)->unique();
            $table->enum('kategori', ['pupuk_organik', 'minyak_jelantah_olahan', 'kerajinan_daur_ulang', 'lainnya'])->default('pupuk_organik');
            $table->string('satuan', 50)->default('kemasan'); // sak 5kg, botol 1L, dll
            $table->integer('stok')->default(0);
            $table->decimal('harga_rupiah', 12, 2);
            $table->boolean('bisa_tukar_saldo')->default(true);
            $table->text('deskripsi')->nullable();
            $table->string('gambar_produk_path')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_olahan');
    }
};

