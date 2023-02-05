<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_barangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('barangs_id');
            $table->unsignedBigInteger('penjualans_id');
            $table->foreign('barangs_id')->references('id')->on('barangs');
            $table->foreign('penjualans_id')->references('id')->on('penjualans')->onDelete('cascade');
            $table->integer('jumlah')->unsigned();
            $table->string('satuan');
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
        Schema::dropIfExists('detail_barangs');
    }
}
