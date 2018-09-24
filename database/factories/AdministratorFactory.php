<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Administrator::class, function (Faker $faker) {
    return [
        'name' => substr($faker->name, 0, 10),
        'email' => hexdec(random_bytes(16)).'@163.com',
        'password' => bcrypt('123123'),
    ];
});
