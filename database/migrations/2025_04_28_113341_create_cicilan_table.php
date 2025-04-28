<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cicilan', function (Blueprint $table) {
            $table->id('cicilan_id');
            $table->decimal('nominal_cicilan', 12, 2); // To store the installment amount
            $table->date('tanggal_cicilan'); // To store the date of installment
            $table->decimal('sisa_hutang', 12, 2); // To store the remaining debt
            $table->unsignedBigInteger('penjualan_id'); // Foreign key referencing penjualan table
            $table->timestamps();

            // Foreign key constraint to ensure integrity between cicilan and penjualan
            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan');
    }
};
