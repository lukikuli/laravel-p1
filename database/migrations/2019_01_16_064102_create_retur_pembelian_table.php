<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_pembelians', function (Blueprint $table) {
            $table->string('no_retur', 30)->primary();
            $table->dateTime('tgl_retur');
            $table->float('hrg_total')->nullable();
            $table->integer('creator')->nullable();
            $table->integer('modifier')->nullable();
            $table->integer('faktur_pembelian')->nullable()->unsigned()->index();
            $table->foreign('faktur_pembelian')->references('no_faktur')->on('pembelians')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->string('keterangan');
            $table->boolean('aktif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retur_pembelians');
    }
}
