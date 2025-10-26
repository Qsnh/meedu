<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;
use App\Services\Other\Interfaces\ViewBlockServiceInterface;
use App\Services\Other\Interfaces\DecorationPageServiceInterface;

class DecorationPageCache
{

    public const KEY_NAME = 'decoration_pages';
    public const BLOCKS_KEY_NAME = 'decoration_page_blocks';
    public const CACHE_EXPIRE = 1296000; // 15天

    private $decorationPageService;
    private $viewBlockService;

    public function __construct(
        DecorationPageServiceInterface $decorationPageService,
        ViewBlockServiceInterface $viewBlockService
    ) {
        $this->decorationPageService = $decorationPageService;
        $this->viewBlockService = $viewBlockService;
    }

    public function get(string $pageKey)
    {
        return Cache::remember($this->key($pageKey), self::CACHE_EXPIRE, function () use ($pageKey) {
            return $this->decorationPageService->getDefaultPageByPageKey($pageKey);
        });
    }

    public function getBlocks(int $pageId): array
    {
        return Cache::remember($this->blocksKey($pageId), self::CACHE_EXPIRE, function () use ($pageId) {
            return $this->viewBlockService->getPageBlocksByPageId($pageId);
        });
    }

    public function getPageWithBlocks(string $pageKey): array
    {
        $page = $this->get($pageKey);

        if (!$page) {
            return [
                'page' => null,
                'blocks' => []
            ];
        }

        $blocks = $this->getBlocks($page['id']);

        return [
            'page' => $page,
            'blocks' => $blocks
        ];
    }

    public function destroy(string $pageKey): void
    {
        Cache::forget($this->key($pageKey));

        // 获取页面信息以清除对应的 blocks 缓存
        $page = $this->decorationPageService->getDefaultPageByPageKey($pageKey);
        if ($page) {
            $this->destroyBlocks($page['id']);
        }
    }

    public function destroyBlocks(int $pageId): void
    {
        Cache::forget($this->blocksKey($pageId));
    }

    private function key(string $pageKey): string
    {
        return self::KEY_NAME . '-' . $pageKey;
    }

    private function blocksKey(int $pageId): string
    {
        return self::BLOCKS_KEY_NAME . '-' . $pageId;
    }

}
