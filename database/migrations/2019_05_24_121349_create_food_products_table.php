<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_products', function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('id_products')->unsigned();
            $table->integer('id_food')->unsigned();
            $table->integer('count');
            $table->foreign('id_products')->references('id')->on('products');
            $table->foreign('id_food')->references('id')->on('foods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('food_products');
    }
}
