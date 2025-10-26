<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Services;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ServiceException;
use App\Services\Other\Models\ViewBlock;
use App\Services\Other\Models\DecorationPage;
use App\Services\Other\Interfaces\DecorationPageServiceInterface;

class DecorationPageService implements DecorationPageServiceInterface
{
    public function getPagesByPageKey(string $pageKey): array
    {
        return DecorationPage::query()
            ->where('page_key', $pageKey)
            ->orderBy('is_default', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    public function getDefaultPageByPageKey(string $pageKey): ?array
    {
        $page = DecorationPage::query()
            ->where('page_key', $pageKey)
            ->where('is_default', 1)
            ->orderBy('id', 'desc')
            ->first();

        return $page ? $page->toArray() : null;
    }

    public function getPage(int $id): ?array
    {
        $page = DecorationPage::query()->where('id', $id)->first();
        return $page ? $page->toArray() : null;
    }

    public function createPage(array $data): int
    {
        $page = DecorationPage::create($data);
        return $page->id;
    }

    public function updatePage(int $id, array $data): void
    {
        DecorationPage::query()
            ->where('id', $id)
            ->update($data);
    }

    public function deletePage(int $id): void
    {
        DB::transaction(function () use ($id) {
            $page = DecorationPage::query()->where('id', $id)->firstOrFail();

            // 默认页面禁止删除
            if ($page->is_default == 1) {
                throw new ServiceException(__('默认页面禁止删除'));
            }

            // 删除关联的装修块（通过 decoration_page_id 关联）
            ViewBlock::query()
                ->where('decoration_page_id', $id)
                ->delete();

            // 删除页面
            $page->delete();
        });
    }

    public function setDefaultPage(int $id): void
    {
        DB::transaction(function () use ($id) {
            $page = DecorationPage::query()->where('id', $id)->firstOrFail();

            // 取消所有其他页面的默认状态
            DecorationPage::query()
                ->where('id', '!=', $id)
                ->where('page_key', $page->page_key)
                ->update(['is_default' => 0]);

            // 设置当前页面为默认
            $page->is_default = 1;
            $page->save();
        });
    }

    public function copyPage(int $id): int
    {
        return DB::transaction(function () use ($id) {
            $page = DecorationPage::query()->where('id', $id)->firstOrFail();

            // 创建新页面
            $newPage = DecorationPage::create([
                'name' => $page->name . ' - 副本',
                'page_key' => $page->page_key,
                'is_default' => 0,
            ]);

            // 复制装修块（通过 decoration_page_id 关联）
            $blocks = ViewBlock::query()
                ->where('decoration_page_id', $id)
                ->orderBy('sort')
                ->get();

            foreach ($blocks as $block) {
                ViewBlock::create([
                    'platform' => $block->platform,
                    'page' => $page->page_key,
                    'decoration_page_id' => $newPage->id,
                    'sign' => $block->sign,
                    'sort' => $block->sort,
                    'config' => $block->config,
                ]);
            }

            return $newPage->id;
        });
    }
}
