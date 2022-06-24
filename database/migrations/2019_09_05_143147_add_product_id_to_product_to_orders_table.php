<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductIdToProductToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('product_to_orders', function (Blueprint $table) {
           $table->integer('product_id', false, true);
           $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('product_to_orders', function (Blueprint $table) {
           $table->dropForeign('product_to_orders_product_id_foreign');
           $table->dropColumn('product_id');
       });
    }
}
