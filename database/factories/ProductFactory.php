<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        //
        "product_name"=> \Str::substr($faker->sentence, 0, 81),
        "product_type_detail"=>1,
        "length"=>$faker->randomFloat(0,10,302),
        "height"=>$faker->randomFloat(0,10,302),
        "width"=>$faker->randomFloat(0,10,302),
        "available"=>1,
        "price"=>$faker->randomFloat(0,100,1000),
        "description"=>\Str::substr($faker->text, 0, 81),
        "product_url"=>"app/public/products/product_".mt_rand(1,6).".jpeg"
    ];
});
