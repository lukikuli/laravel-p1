<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditKonversiBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konversi_barangs', function (Blueprint $table) {
            $table->foreign('kode_barang_masuk')->references('kode')->on('barangs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('kode_barang_keluar')->references('kode')->on('barangs')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konversi_barangs', function (Blueprint $table) {
            //
        });
    }
}
