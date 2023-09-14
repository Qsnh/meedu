<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Other\Models;

use App\Services\Other\Models\AdFrom;
use App\Services\Other\Models\AdFromNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFromNumberFactory extends Factory
{
    protected $model = AdFromNumber::class;

    public function definition()
    {
        return [
            'from_id' => function () {
                return AdFrom::factory()->create()->id;
            },
            'day' => $this->faker->date(),
            'num' => mt_rand(0, 100),
        ];
    }
}
