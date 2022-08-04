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
use App\Services\Other\Models\Link;
use App\Http\Requests\Backend\LinkRequest;

class LinkController extends BaseController
{
    public function index(Request $request)
    {
        $links = Link::query()->orderBy('sort')->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_LINK,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($links);
    }

    public function store(LinkRequest $request)
    {
        $data = $request->filldata();

        Link::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_LINK,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($id)
    {
        $link = Link::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_LINK,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($link);
    }

    public function update(LinkRequest $request, $id)
    {
        $data = $request->filldata();
        $link = Link::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_LINK,
            AdministratorLog::OPT_UPDATE,
            Arr::only($data, ['sort', 'name', 'url']),
            Arr::only($link->toArray(), ['sort', 'name', 'url'])
        );

        $link->fill($data)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        Link::destroy($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_LINK,
            AdministratorLog::OPT_DESTROY,
            []
        );

        return $this->success();
    }
}
