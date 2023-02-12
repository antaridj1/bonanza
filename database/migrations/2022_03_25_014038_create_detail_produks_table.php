<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_produks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produks_id');
            $table->unsignedBigInteger('penjualans_id');
            $table->foreign('produks_id')->references('id')->on('produks');
            $table->foreign('penjualans_id')->references('id')->on('penjualans')->onDelete('cascade');
            $table->integer('jumlah')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_produks');
    }
}
