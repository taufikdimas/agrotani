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
        Schema::create('stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->unsignedBigInteger('penjualan_id');
            $table->unsignedBigInteger('produk_id');
            $table->enum('kategori', ['in', 'out']);
            $table->integer('jumlah');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('produk_id')->on('produk');
            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
