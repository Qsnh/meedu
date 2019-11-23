<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Models\AdFrom;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\AdFromRequest;

class AdFromController extends BaseController
{
    public function index()
    {
        $links = AdFrom::orderByDesc('id')->paginate(\request()->input('size', 12));

        return $this->successData($links);
    }

    public function store(AdFromRequest $request)
    {
        AdFrom::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $info = AdFrom::findOrFail($id);

        return $this->successData($info);
    }

    public function update(AdFromRequest $request, $id)
    {
        $role = AdFrom::findOrFail($id);
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        AdFrom::destroy($id);

        return $this->success();
    }

    public function number(Request $request, $id)
    {
        $ad = AdFrom::findOrFail($id);
        $startDate = $request->input('start_date', date('Y-m-d', Carbon::now()->subDays(30)->timestamp));
        $endDate = $request->input('end_date', date('Y-m-d', Carbon::now()->timestamp));
        $records = $ad->numbers()->whereBetween('day', [$startDate, $endDate])->get();
        $rows = collect([]);
        foreach ($records as $item) {
            $rows->push([
                'x' => $item->day,
                'y' => $item->num,
            ]);
        }

        return $this->successData(compact('ad', 'rows'));
    }
}
