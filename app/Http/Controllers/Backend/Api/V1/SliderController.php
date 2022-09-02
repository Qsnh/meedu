<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Other\Models\Slider;
use App\Http\Requests\Backend\SliderRequest;

class SliderController extends BaseController
{
    public function index(Request $request)
    {
        $platform = $request->input('platform');

        $sliders = Slider::query()
            ->when($platform, function ($query) use ($platform) {
                $query->where('platform', $platform);
            })
            ->orderBy('sort')
            ->get();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SLIDER,
            AdministratorLog::OPT_VIEW,
            compact('platform')
        );

        return $this->successData($sliders);
    }

    public function store(SliderRequest $request)
    {
        $data = $request->filldata();

        Slider::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SLIDER,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($id)
    {
        $slider = Slider::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SLIDER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($slider);
    }

    public function update(SliderRequest $request, $id)
    {
        $data = $request->filldata();

        $slider = Slider::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_SLIDER,
            AdministratorLog::OPT_UPDATE,
            $data,
            Arr::only($slider->toArray(), ['thumb', 'sort', 'url', 'platform'])
        );

        $slider->fill($data)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        Slider::destroy($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SLIDER,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }
}
