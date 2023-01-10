<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call(AddCategorySeeder::class);
       $this->call(ProductsTableSeeder::class);
       $this->call(OfficesTableSeeder::class);
       $this->call(UsersTableSeeder::class);
       $this->call(ShopsTableSeeder::class);
    }
}
