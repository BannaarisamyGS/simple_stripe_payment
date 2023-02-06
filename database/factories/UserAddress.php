<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserAddresses;
use Faker\Generator as Faker;

$factory->define(UserAddresses::class, function (Faker $faker) {
    return [
        //
        "user_id"=>mt_rand(1,10),
        "line1"=>\Str::substr($faker->text, 0, 30),
        "line2"=>\Str::substr($faker->text, 0, 30),
        "city"=>$faker->sentence(),
        "country"=>"IN",
        "postal_code"=>mt_rand(100000,600000),
        "state"=>"TN"
    ];
});
