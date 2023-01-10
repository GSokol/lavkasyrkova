<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class AddProductDetailInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->after('name');
            $table->string('short_description')->nullable()->after('description'); // Короткое описание
            $table->text('gastro_combination')->nullable()->after('short_description'); // Гастрономическое сочетание
            $table->text('alcohol_combination')->nullable()->after('gastro_combination'); // Алкоголь
            $table->string('rennet_type')->nullable()->after('alcohol_combination'); // Сычужный тип
            $table->text('nutrients')->nullable()->after('rennet_type'); // Питательные вещества
            $table->string('aging')->nullable()->after('nutrients'); // Выдержка
            $table->string('shelf_life')->nullable()->after('aging'); // Срок хранения
        });
        $products = Product::all();
        foreach ($products as $product) {
            $product->touch();
        }
        Schema::table('products', function (Blueprint $table) {
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_slug_unique');
            $table->dropColumn('shelf_life');
            $table->dropColumn('aging');
            $table->dropColumn('nutrients');
            $table->dropColumn('rennet_type');
            $table->dropColumn('alcohol_combination');
            $table->dropColumn('gastro_combination');
            $table->dropColumn('short_description');
            $table->dropColumn('slug');
        });
    }
}
