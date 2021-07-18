<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Meedu\Hooks\HookRun;
use Illuminate\Http\Request;
use App\Meedu\Hooks\HookParams;
use App\Meedu\ViewBlock\Constant;
use App\Services\Other\Models\ViewBlock;
use App\Meedu\Hooks\Constant\PositionConstant;

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

        foreach ($blocks as $index => $blockItem) {
            $blocks[$index] = HookRun::run(PositionConstant::VIEW_BLOCK_DATA_RENDER, new HookParams(['block' => $blockItem]));
        }

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

        ViewBlock::create([
            'platform' => $platform,
            'page' => $page,
            'sign' => $sign,
            'config' => json_encode($config ?: []),
            'sort' => $sort,
        ]);

        return $this->success();
    }

    public function edit($id)
    {
        $block = ViewBlock::query()->where('id', $id)->firstOrFail();
        return $this->successData($block);
    }

    public function update(Request $request, $id)
    {
        $config = $request->input('config');
        $sort = $request->input('sort');

        $block = ViewBlock::query()->where('id', $id)->firstOrFail();

        $block->fill(['config' => $config, 'sort' => $sort])->save();

        return $this->success();
    }

    public function destroy($id)
    {
        ViewBlock::query()->where('id', $id)->delete();
        return $this->success();
    }
}
