<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\FaqCategory::class, function (Faker $faker) {
    return [
        'sort' => $faker->randomDigit,
        'name' => $faker->name,
    ];
});
