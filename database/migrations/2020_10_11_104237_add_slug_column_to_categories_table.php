<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\AddCategory;
use App\Models\Category;

class AddSlugColumnToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug', 255)->after('name');
        });
        Category::all()->each(function($category) {
            $category->update([
                'slug' => str_slug($category->name, '-'),
            ]);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('add_categories', function (Blueprint $table) {
            $table->string('slug', 255)->after('name');
        });
        AddCategory::all()->each(function($category) {
            $category->update([
                'slug' => str_slug($category->name, '-'),
            ]);
        });
        Schema::table('add_categories', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('add_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
