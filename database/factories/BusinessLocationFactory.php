<?php

/*
|--------------------------------------------------------------------------
| Business Locations Factories
|--------------------------------------------------------------------------
|

|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\BusinessLocations::class, function (Faker\Generator $faker) {


    return [
        'name' => $faker->name,
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'postal_code' => $faker->postcode,
        'pictures'=>[]
    ];
});
