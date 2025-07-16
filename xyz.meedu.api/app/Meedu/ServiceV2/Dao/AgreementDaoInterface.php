<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

interface AgreementDaoInterface
{
    /**
     * 根据类型获取激活的协议
     */
    public function getActiveAgreementsByTypes(array $types): array;

    /**
     * 根据类型获取单个激活的协议
     */
    public function getActiveAgreementByType(string $type, array $fields = ['*']): array;

    /**
     * 获取所有激活的协议
     */
    public function getActiveAgreements(): array;

    /**
     * 根据 ID 查找协议
     */
    public function findAgreementById(int $id): array;

    /**
     * 获取用户同意的协议数量
     */
    public function getUserAgreementRecordCountByAgreementIds(int $userId, array $agreementIds): int;

    /**
     * 创建或更新用户协议记录
     */
    public function createOrUpdateUserAgreementRecord(array $data): array;

    /**
     * 获取用户的协议记录
     */
    public function getUserAgreementRecordsByAgreementIds(int $userId, array $agreementIds): array;
}
