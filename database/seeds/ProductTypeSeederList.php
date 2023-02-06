<?php

use Illuminate\Database\Seeder;

class ProductTypeSeederList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\ProductType::class,6)->create();
    }
}
