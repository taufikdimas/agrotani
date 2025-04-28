<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('produk_id');
            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->decimal('hpp', 12, 2)->nullable(); // Added hpp column
            $table->integer('stok')->default(0);
            $table->integer('min_stok')->default(0);
            $table->string('gambar')->nullable(); // Added gambar column
            $table->integer('stok_in')->default(0); // Added stok_in column
            $table->integer('stok_out')->default(0); // Added stok_out column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
