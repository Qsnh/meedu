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
use App\Events\DecorationPageUpdateEvent;
use App\Services\Other\Models\DecorationPage;

class ViewBlockController extends BaseController
{
    public function index(Request $request)
    {
        $page = $request->input('page');
        $platform = $request->input('platform');
        $pageId = $request->input('page_id');

        $query = ViewBlock::query();

        // 优先使用 page_id 查询
        if ($pageId) {
            $query->where('decoration_page_id', $pageId);
        } // 向后兼容：如果没有 page_id，使用 platform 和 page 查询
        elseif ($page && $platform) {
            $query->where('platform', $platform)->where('page', $page);
        } else {
            return $this->error(__('参数错误'));
        }

        $blocks = $query->orderBy('sort')->get()->toArray();

        $blocks = Render::dataRender($blocks);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_VIEW,
            compact('page', 'platform', 'pageId')
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
        $pageId = (int)$request->input('page_id');
        $sign = $request->input('sign');
        $config = $request->input('config');
        $sort = (int)$request->input('sort');

        if (!$sign) {
            return $this->error(__('参数错误'));
        }

        if (!$pageId) {
            return $this->error(__('参数错误'));
        }

        $decorationPage = DecorationPage::query()->where('id', $pageId)->firstOrFail();

        $data = [
            'platform' => '',
            'page' => '',
            'decoration_page_id' => $pageId,
            'sign' => $sign,
            'config' => json_encode($config ?: []),
            'sort' => $sort,
        ];

        ViewBlock::query()->create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_STORE,
            $data
        );

        event(new DecorationPageUpdateEvent($decorationPage['page_key']));

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

        // 触发缓存清除事件
        if ($block->decoration_page_id) {
            $decorationPage = DecorationPage::query()->find($block->decoration_page_id);
            if ($decorationPage) {
                event(new DecorationPageUpdateEvent($decorationPage->page_key));
            }
        }

        return $this->success();
    }

    public function destroy($id)
    {
        $block = ViewBlock::query()->where('id', $id)->first();

        ViewBlock::query()->where('id', $id)->delete();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        // 触发缓存清除事件
        if ($block && $block->decoration_page_id) {
            $decorationPage = DecorationPage::query()->find($block->decoration_page_id);
            if ($decorationPage) {
                event(new DecorationPageUpdateEvent($decorationPage->page_key));
            }
        }

        return $this->success();
    }
}
