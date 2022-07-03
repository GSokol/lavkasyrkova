<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultValueOnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('action')->default(false)->change();
            $table->boolean('parts')->default(false)->change();
            $table->integer('part_price')->nullable()->change();
            $table->integer('action_whole_price')->nullable()->change();
            $table->integer('action_part_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('action')->default(null)->change();
            $table->boolean('parts')->default(null)->change();
            $table->integer('part_price')->nullable(false)->change();
            $table->integer('action_whole_price')->nullable(false)->change();
            $table->integer('action_part_price')->nullable(false)->change();
        });
    }
}
