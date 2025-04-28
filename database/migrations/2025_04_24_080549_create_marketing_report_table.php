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
        Schema::create('marketing_report', function (Blueprint $table) {
            $table->id('marketing_report_id');
            $table->unsignedBigInteger('marketing_id');
            $table->string('bulan'); // Format: YYYY-MM
            $table->decimal('omset', 12, 2)->default(0);
            $table->decimal('profit', 12, 2)->default(0);
            $table->decimal('loss', 12, 2)->default(0);
            $table->decimal('receivable', 12, 2)->default(0);
            $table->decimal('payable', 12, 2)->default(0);
            $table->timestamps();

            $table->foreign('marketing_id')->references('marketing_id')->on('marketing')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_report');
    }
};
