<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKonversiBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konversi_barangs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stok_keluar')->nullable();
            $table->integer('stok_masuk')->nullable();
            $table->string('kode_barang_masuk', 30)->index()->nullable();
            $table->string('kode_barang_keluar', 30)->index()->nullable();
            $table->integer('creator')->nullable();
            $table->integer('modifier')->nullable();
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
        Schema::dropIfExists('konversi_barangs');
    }
}
