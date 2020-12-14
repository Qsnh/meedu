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
use Illuminate\Http\Request;
use App\Services\Other\Models\AdFrom;
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
        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->subMonths(1)));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()));
        $records = $ad->numbers()->select(['day', 'num'])->whereBetween('day', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get();
        $data = [];
        while ($startDate->lt($endDate)) {
            $data[$startDate->format('Y-m-d')] = 0;
            $startDate->addDays(1);
        }
        foreach ($records as $record) {
            $data[$record->day] += $record->num;
        }
        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }
}
