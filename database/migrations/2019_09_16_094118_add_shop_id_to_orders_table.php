<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('orders', function (Blueprint $table) {
//            $table->integer('shop_id', false, true)->nullable();
//            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('orders', function (Blueprint $table) {
//            $table->dropForeign('orders_shop_id_foreign');
//            $table->dropColumn('shop_id');
//        });
    }
}
