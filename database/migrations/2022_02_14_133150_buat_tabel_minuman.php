<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelMinuman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listminuman', function($table)
        {
            $table->increments('_id');
            $table->string('nama_minuman', 200)->required();
            $table->integer('harga');
            $table->longText('deskripsi_minuman')->nullable();
            $table->enum('status',['ice','hot']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listminuman');
    }
}
