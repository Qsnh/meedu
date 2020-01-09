<?php

use Faker\Generator as Faker;

$factory->define(\App\Services\Order\Models\PromoCode::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'code' => \Illuminate\Support\Str::random(),
        'expired_at' => null,
        'invite_user_reward' => mt_rand(0, 100),
        'invited_user_reward' => mt_rand(0, 100),
        'use_times' => 1,
        'used_times' => 0,
    ];
});
