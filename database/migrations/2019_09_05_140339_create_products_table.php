<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('products', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name');
//            $table->text('additionally')->nullable();
//            $table->text('description');
//            $table->string('image')->nullable();
//            $table->string('big_image')->nullable();
//            $table->boolean('parts');
//            $table->integer('whole_price');
//            $table->integer('whole_weight');
//            $table->integer('part_price');
//            $table->integer('action_whole_price');
//            $table->integer('action_part_price');
//            $table->boolean('new');
//            $table->boolean('action');
//            $table->boolean('active');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('products');
    }
}
