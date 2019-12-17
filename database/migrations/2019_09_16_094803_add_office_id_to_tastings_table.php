<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfficeIdToTastingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('tastings', function (Blueprint $table) {
//            $table->integer('office_id', false, true)->nullable();
//            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade')->onUpdate('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('tastings', function (Blueprint $table) {
//            $table->dropForeign('tastings_office_id_foreign');
//            $table->dropColumn('office_id');
//        });
    }
}
