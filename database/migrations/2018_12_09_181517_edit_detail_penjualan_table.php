<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDetailPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_penjualans', function (Blueprint $table) {
            $table->float('diskon_harga')->nullable();
            $table->float('harga_barang')->nullable();
            $table->float('harga_barang_diskon')->nullable();
            $table->integer('diskon_persen')->nullable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_penjualans', function (Blueprint $table) {
            $table->dropColumn('diskon_harga');
            $table->dropColumn('diskon_persen');
        });
    }
}
