<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductType;
use Faker\Generator as Faker;

$factory->define(ProductType::class, function (Faker $faker) {
    return [
        //
        "product_type_name"=>\Str::substr($faker->sentence,0,9)
    ];
});
