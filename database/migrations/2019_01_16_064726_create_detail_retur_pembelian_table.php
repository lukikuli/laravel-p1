<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailReturPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_retur_pembelians', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jmlh_retur');
            $table->integer('jmlh_ganti');
            $table->float('subtotal');
            $table->integer('creator')->nullable();
            $table->integer('modifier')->nullable();
            $table->string('retur_pembelian', 30)->index()->nullable();
            $table->foreign('retur_pembelian')->references('no_retur')->on('retur_pembelians')->onUpdate('cascade')->onDelete('restrict');
            $table->string('kode_barang', 30)->index()->nullable();
            $table->foreign('kode_barang')->references('kode')->on('barangs')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_retur_pembelians');
    }
}
