<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jmlh');
            $table->float('subtotal');
            $table->integer('creator')->nullable();
            $table->integer('modifier')->nullable();
            $table->string('faktur_penjualan', 30)->index()->nullable();
            $table->foreign('faktur_penjualan')->references('no_faktur')->on('penjualans')->onUpdate('cascade')->onDelete('restrict');
            $table->string('kode_barang', 30)->index()->nullable();
            $table->foreign('kode_barang')->references('kode')->on('barangs')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('detail_penjualans');
    }
}
