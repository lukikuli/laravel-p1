<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->string('no_faktur', 30)->primary();
            $table->timestamp('tgl_jual');
            $table->float('hrg_total');
            $table->float('diskon_harga');
            $table->float('diskon_persen');
            $table->integer('creator')->nullable();
            $table->integer('modifier')->nullable();
            $table->integer('pelanggan_id')->nullable()->unsigned()->index();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
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
        Schema::dropIfExists('penjualans');
    }
}
