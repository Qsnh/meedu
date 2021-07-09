<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Services\Other\Models\Slider;
use App\Http\Requests\Backend\SliderRequest;

class SliderController extends BaseController
{
    public function index()
    {
        $links = Slider::orderBy('sort')->get();

        return $this->successData($links);
    }

    public function store(SliderRequest $request)
    {
        Slider::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $link = Slider::findOrFail($id);

        return $this->successData($link);
    }

    public function update(SliderRequest $request, $id)
    {
        $role = Slider::findOrFail($id);
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        Slider::destroy($id);

        return $this->success();
    }
}
