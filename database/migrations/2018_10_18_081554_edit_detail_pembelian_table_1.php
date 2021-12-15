<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDetailPembelianTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->string('faktur_pembelian', 30)->nullable()->change();
            $table->foreign('faktur_pembelian')->references('no_faktur')->on('pembelians')->onUpdate('cascade')->onDelete('restrict');
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
            $table->dropForeign(['faktur_pembelian']);
            $table->dropColumn('faktur_pembelian');
        });
    }
}
