<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Meedu\ViewBlock\Render;
use App\Models\AdministratorLog;
use App\Meedu\ViewBlock\Constant;
use App\Services\Other\Models\ViewBlock;

class ViewBlockController extends BaseController
{
    public function index(Request $request)
    {
        $page = $request->input('page');
        $platform = $request->input('platform');
        if (!$page || !$platform) {
            return $this->error(__('参数错误'));
        }

        $blocks = ViewBlock::query()
            ->where('platform', $platform)
            ->where('page', $page)
            ->orderBy('sort')
            ->get()
            ->toArray();

        $blocks = Render::dataRender($blocks);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_VIEW,
            compact('page', 'platform')
        );

        return $this->successData($blocks);
    }

    public function create()
    {
        return $this->successData([
            'page' => Constant::H5_PAGE_INDEX_V1,
            'blocks' => Constant::PAGE_BLOCKS[Constant::H5_PAGE_INDEX_V1],
        ]);
    }

    public function store(Request $request)
    {
        $page = $request->input('page');
        $sign = $request->input('sign');
        $platform = $request->input('platform');
        $config = $request->input('config');
        $sort = $request->input('sort');

        if (!$page || !$sign || !$platform) {
            return $this->error(__('参数错误'));
        }

        $data = [
            'platform' => $platform,
            'page' => $page,
            'sign' => $sign,
            'config' => json_encode($config ?: []),
            'sort' => $sort,
        ];

        ViewBlock::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($id)
    {
        $block = ViewBlock::query()->where('id', $id)->firstOrFail();
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );
        return $this->successData($block);
    }

    public function update(Request $request, $id)
    {
        $config = $request->input('config');
        $sort = $request->input('sort');
        $updateData = ['config' => $config, 'sort' => $sort];

        $block = ViewBlock::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_UPDATE,
            $updateData,
            Arr::only($block->toArray(), ['config', 'sort'])
        );

        $block->fill($updateData)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        ViewBlock::query()->where('id', $id)->delete();
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );
        return $this->success();
    }
}
