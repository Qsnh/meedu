<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Other\Models\AdFrom;
use App\Http\Requests\Backend\AdFromRequest;

class AdFromController extends BaseController
{
    public function index(Request $request)
    {
        $list = AdFrom::query()->orderByDesc('id')->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AD_FROM,
            AdministratorLog::OPT_VIEW,
            $request->path()
        );

        return $this->successData($list);
    }

    public function store(AdFromRequest $request)
    {
        $data = $request->filldata();

        AdFrom::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AD_FROM,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($id)
    {
        $record = AdFrom::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AD_FROM,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($record);
    }

    public function update(AdFromRequest $request, $id)
    {
        $record = AdFrom::query()->where('id', $id)->firstOrFail();

        $data = $request->filldata();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_AD_FROM,
            AdministratorLog::OPT_UPDATE,
            Arr::only($data, ['from_name', 'from_key']),
            Arr::only($record->toArray(), ['from_name', 'from_key'])
        );

        $record->fill($data)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        AdFrom::destroy($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AD_FROM,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }

    public function number(Request $request, $id)
    {
        $ad = AdFrom::query()->where('id', $id)->firstOrFail();

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AD_FROM,
            AdministratorLog::OPT_VIEW,
            $request->path()
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }
}
