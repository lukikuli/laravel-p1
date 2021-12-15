<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetodeBayarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metode_bayars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_metode');
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
        Schema::dropIfExists('metode_bayars');
    }
}
