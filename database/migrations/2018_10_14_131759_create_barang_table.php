<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->string('kode', 30)->primary();
            $table->string('nama');
            $table->integer('stok');
            $table->float('harga_jual');
            $table->float('harga_beli');
            $table->integer('creator')->nullable();
            $table->integer('modifier')->nullable();
            $table->integer('jenis_id')->unsigned()->nullable()->index();
            $table->foreign('jenis_id')->references('id')->on('jenis_barangs')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('barangs');
    }
}
