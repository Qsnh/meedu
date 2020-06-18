<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Faker\Generator as Faker;
use App\Services\Member\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'avatar' => $faker->imageUrl(),
        'nick_name' => $faker->firstName . mt_rand(0, 100),
        'mobile' => $faker->randomElement(['136', '188', '159']) . mt_rand(1000, 9999) . mt_rand(1000, 9999),
        'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        'credit1' => 0,
        'credit2' => 0,
        'credit3' => 0,
        'is_active' => $faker->randomElement([User::ACTIVE_NO, User::ACTIVE_YES]),
        'is_lock' => $faker->randomElement([User::LOCK_NO, User::LOCK_YES]),
        'role_id' => 0,
        'role_expired_at' => \Carbon\Carbon::now(),
    ];
});
