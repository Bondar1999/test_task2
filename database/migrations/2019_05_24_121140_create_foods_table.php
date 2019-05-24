<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('cooking_time');
            $table->date('date_of_cooking');
            $table->integer('sell_price');
            $table->integer('id_worker')->unsigned();
            $table->integer('profit')->default(0);
            $table->primary('id');
            $table->foreign('id_worker')->references('id')->on('worker')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('foods');
    }
}
