<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Factories\Services\Other\Models;

use App\Constant\FrontendConstant;
use App\Services\Other\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    protected $model = Slider::class;

    public function definition()
    {
        return [
            'sort' => $this->faker->randomDigit,
            'url' => $this->faker->url,
            'thumb' => $this->faker->imageUrl(),
            'platform' => $this->faker->randomElement([
                FrontendConstant::SLIDER_PLATFORM_MINI,
                FrontendConstant::SLIDER_PLATFORM_APP,
                FrontendConstant::SLIDER_PLATFORM_H5,
                FrontendConstant::SLIDER_PLATFORM_PC
            ]),
        ];
    }
}
