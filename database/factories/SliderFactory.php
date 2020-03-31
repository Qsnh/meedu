<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Services\Other\Models\Slider::class, function (Faker $faker) {
    return [
        'sort' => $faker->randomDigit,
        'url' => $faker->url,
        'thumb' => $faker->imageUrl(),
    ];
});
