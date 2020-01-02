<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Member\Models\Socialite::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Services\Member\Models\User::class)->create()->id;
        },
        'app' => \Illuminate\Support\Str::random(6),
        'app_user_id' => \Illuminate\Support\Str::random(),
        'data' => '',
    ];
});
