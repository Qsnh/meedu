<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;
use App\Services\Other\Interfaces\ViewBlockServiceInterface;

class ViewBlockCache
{

    public const KEY_NAME = 'viewBlocks';

    private $viewBlockService;

    public function __construct(ViewBlockServiceInterface $viewBlockService)
    {
        $this->viewBlockService = $viewBlockService;
    }

    public function get(string $platform, string $pageName)
    {
        return Cache::get($this->key($platform, $pageName), function () use ($platform, $pageName) {
            return $this->viewBlockService->getPageBlocks($platform, $pageName);
        });
    }

    public function destroy(string $platform, string $pageName): void
    {
        Cache::forget($this->key($platform, $pageName));
    }

    private function key(string $platform, string $pageName): string
    {
        return self::KEY_NAME . '-' . $platform . '-' . $pageName;
    }

}
