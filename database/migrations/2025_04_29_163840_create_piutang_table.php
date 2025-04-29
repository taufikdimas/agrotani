<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiutangsTable extends Migration
{
    public function up()
    {
        Schema::create('piutang', function (Blueprint $table) {
            $table->id('piutang_id');
            $table->string('nama'); 
            $table->date('tanggal_order');
            $table->unsignedBigInteger('produk_id');
            $table->integer('jumlah');
            $table->decimal('tagihan', 15, 2);
            $table->timestamps();

            $table->foreign('produk_id')->references('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('piutang');
    }
}

