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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('kode_transaksi')->unique(); // Renamed from no_invoice
            $table->date('tanggal_transaksi'); // Renamed from tgl_penjualan
            $table->decimal('total_harga', 12, 2);
            $table->decimal('dibayar', 12, 2)->default(0); // Added dibayar
            $table->decimal('laba_bersih', 12, 2)->nullable(); // Added laba_bersih
            $table->enum('status_pembayaran', ['lunas', 'belum lunas'])->default('belum lunas'); // Renamed from payment_status
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customer');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
