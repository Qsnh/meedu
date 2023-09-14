<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Other\Models;

use App\Services\Other\Models\AdFrom;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFromFactory extends Factory
{
    protected $model = AdFrom::class;

    public function definition()
    {
        return [
            'from_name' => $this->faker->name,
            'from_key' => $this->faker->name,
        ];
    }
}
