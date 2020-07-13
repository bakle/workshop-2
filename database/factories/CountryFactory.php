<?php

/** @var Factory $factory */

use App\Country;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name' => $faker->country,
        'numeric_code' => $faker->unique()->numberBetween(100, 999),
        'alpha_2_code' => $faker->unique()->countryCode,
        'alpha_3_code' => $faker->unique()->countryISOAlpha3,
    ];
});
