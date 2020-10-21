<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualValueColumnToProductToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_to_orders', function (Blueprint $table) {
            $table->integer('actual_value')->nullable()->after('part_value');
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
            $table->dropColumn('actual_value');
        });
    }
}
