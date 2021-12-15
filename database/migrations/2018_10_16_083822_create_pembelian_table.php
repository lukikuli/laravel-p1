<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->string('no_faktur', 30)->primary();
            $table->timestamp('tgl_beli');
            $table->float('hrg_total');
            $table->integer('creator')->nullable();
            $table->integer('modifier')->nullable();
            $table->integer('supplier_id')->nullable()->unsigned()->index();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('pembelians');
    }
}
