<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegenciesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regencies', function(Blueprint $table){
            $table->increments('id')->length(4);
            $table->integer('province_id')->length(2)->unsigned();
            $table->string('name');
            $table->foreign('province_id')
                ->references('id')
                ->on('provinces')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regencies');
    }
}
