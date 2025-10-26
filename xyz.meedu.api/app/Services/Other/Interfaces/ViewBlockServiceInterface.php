<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Interfaces;

interface ViewBlockServiceInterface
{
    /**
     * 根据装修页面ID获取装修块
     *
     * @param int $pageId
     * @return array
     */
    public function getPageBlocksByPageId(int $pageId): array;
}
