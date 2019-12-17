<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToUserToTastingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('user_to_tastings', function (Blueprint $table) {
//            $table->integer('user_id', false, true);
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('user_to_tastings', function (Blueprint $table) {
//            $table->dropForeign('user_to_tastings_user_id_foreign');
//            $table->dropColumn('user_id');
//        });
    }
}
