<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderIdToProductToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('product_to_orders', function (Blueprint $table) {
//            $table->integer('order_id', false, true);
//            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('product_to_orders', function (Blueprint $table) {
//            $table->dropForeign('product_to_orders_order_id_foreign');
//            $table->dropColumn('order_id');
//        });
    }
}
