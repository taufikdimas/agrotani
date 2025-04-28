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
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('nama_customer');
            $table->string('perusahaan_customer')->nullable();
            $table->text('alamat_customer')->nullable();
            $table->string('no_hp_customer')->nullable();
            $table->decimal('hutang_customer', 12, 2)->default(0); // Updated precision to (12, 2)
            $table->boolean('is_deleted')->default(false); // Added is_deleted column
            $table->timestamps();
            $table->softDeletes();  // Automatically adds the deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
