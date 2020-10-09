<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTastingIdToUserToTastingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('user_to_tastings', function (Blueprint $table) {
           $table->integer('tasting_id', false, true);
           $table->foreign('tasting_id')->references('id')->on('tastings')->onDelete('cascade')->onUpdate('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('user_to_tastings', function (Blueprint $table) {
           $table->dropForeign('user_to_tastings_tasting_id_foreign');
           $table->dropColumn('tasting_id');
       });
    }
}
