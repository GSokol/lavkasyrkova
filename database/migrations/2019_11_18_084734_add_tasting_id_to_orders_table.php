<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTastingIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('orders', function (Blueprint $table) {
//            $table->integer('tasting_id', false, true)->nullable();
//            $table->foreign('tasting_id')->references('id')->on('tastings')->onDelete('cascade')->onUpdate('cascade');
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
//            $table->dropForeign('orders_tasting_id_foreign');
//            $table->dropColumn('tasting_id');
//        });
    }
}
