<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('status_id')->after('status');
        });
        // update
        DB::unprepared("UPDATE `orders` SET `status_id` = CASE `status` WHEN 1 THEN 1 WHEN 2 THEN 3 ELSE `status_id` END");
        // foreign key
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('order_status')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
}
