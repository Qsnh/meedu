<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Services\Course\Models\Course;
use App\Services\Other\Models\IndexBanner;
use App\Http\Requests\Backend\IndexBannerRequest;

class IndexBannerController extends BaseController
{
    public function index()
    {
        $data = IndexBanner::orderBy('sort')->get();
        return $this->successData($data);
    }

    public function create()
    {
        $courses = Course::select(['id', 'title', 'thumb'])->get();
        return $this->successData(compact('courses'));
    }

    public function store(IndexBannerRequest $request)
    {
        IndexBanner::create($request->filldata());
        return $this->success();
    }

    public function edit($id)
    {
        $data = IndexBanner::whereId($id)->firstOrFail();
        return $this->successData($data);
    }

    public function update(IndexBannerRequest $request, $id)
    {
        $banner = IndexBanner::whereId($id)->firstOrFail();
        $banner->fill($request->filldata())->save();
        return $this->success();
    }

    public function destroy($id)
    {
        IndexBanner::destroy($id);
        return $this->success();
    }
}
