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
            $table->primary('id');
            $table->foreign('id_products')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_food')->references('id')->on('food')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
