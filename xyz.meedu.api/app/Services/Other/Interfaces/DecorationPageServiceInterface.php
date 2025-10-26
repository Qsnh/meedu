<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Interfaces;

interface DecorationPageServiceInterface
{
    public function getPagesByPageKey(string $pageKey): array;

    public function getDefaultPageByPageKey(string $pageKey): ?array;

    /**
     * 根据ID获取页面
     *
     * @param int $id
     * @return array|null
     */
    public function getPage(int $id): ?array;

    /**
     * 创建装修页面
     *
     * @param array $data
     * @return int
     */
    public function createPage(array $data): int;

    /**
     * 更新装修页面
     *
     * @param int $id
     * @param array $data
     * @return void
     */
    public function updatePage(int $id, array $data): void;

    /**
     * 删除装修页面
     *
     * @param int $id
     * @return void
     */
    public function deletePage(int $id): void;

    /**
     * 设置默认页面
     *
     * @param int $id
     * @return void
     */
    public function setDefaultPage(int $id): void;

    /**
     * 复制页面
     *
     * @param int $id
     * @return int 新页面ID
     */
    public function copyPage(int $id): int;
}
