<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDetailPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->string('kode_barang', 30)->index()->nullable();
            $table->foreign('kode_barang')->references('kode')->on('barangs')->onUpdate('cascade')->onDelete('restrict');
            $table->dropForeign(['faktur_pembelian']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->dropForeign(['kode_barang']);
            $table->dropColumn('kode_barang');
        });
    }
}
