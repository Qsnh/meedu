<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Other\Models\AdFrom::class, function (Faker $faker) {
    return [
        'from_name' => $faker->name,
        'from_key' => $faker->name,
    ];
});
