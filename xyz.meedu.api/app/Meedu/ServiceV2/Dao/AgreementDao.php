<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use App\Meedu\ServiceV2\Models\Agreement;
use App\Meedu\ServiceV2\Models\AgreementUserRecord;

class AgreementDao implements AgreementDaoInterface
{
    /**
     * 根据类型获取激活的协议
     */
    public function getActiveAgreementsByTypes(array $types): array
    {
        return Agreement::query()
            ->select(['id'])
            ->where('is_active', 1)
            ->whereIn('type', $types)
            ->get()
            ->toArray();
    }

    /**
     * 根据类型获取单个激活的协议
     */
    public function getActiveAgreementByType(string $type, array $fields = ['*']): array
    {
        $record = Agreement::query()
            ->select($fields)
            ->where('is_active', 1)
            ->where('type', $type)
            ->first();
        
        return $record ? $record->toArray() : [];
    }

    /**
     * 获取所有激活的协议
     */
    public function getActiveAgreements(): array
    {
        return Agreement::query()
            ->where('is_active', 1)
            ->select(['id', 'type'])
            ->get()
            ->keyBy('type')
            ->toArray();
    }

    /**
     * 根据 ID 查找协议
     */
    public function findAgreementById(int $id): array
    {
        $record = Agreement::query()->find($id);
        return $record ? $record->toArray() : [];
    }

    /**
     * 获取用户同意的协议数量
     */
    public function getUserAgreementRecordCountByAgreementIds(int $userId, array $agreementIds): int
    {
        return AgreementUserRecord::query()
            ->where('user_id', $userId)
            ->whereIn('agreement_id', $agreementIds)
            ->count();
    }

    /**
     * 创建或更新用户协议记录
     */
    public function createOrUpdateUserAgreementRecord(array $data): array
    {
        $record = AgreementUserRecord::query()
            ->updateOrCreate(
                ['user_id' => $data['user_id'], 'agreement_id' => $data['agreement_id']],
                [
                    'agreement_type' => $data['agreement_type'],
                    'agreement_version' => $data['agreement_version'],
                    'agreed_at' => $data['agreed_at'],
                    'ip' => $data['ip'],
                    'user_agent' => $data['user_agent'],
                    'platform' => $data['platform'],
                ]
            );
        
        return $record->toArray();
    }

    /**
     * 获取用户的协议记录
     */
    public function getUserAgreementRecordsByAgreementIds(int $userId, array $agreementIds): array
    {
        return AgreementUserRecord::query()
            ->where('user_id', $userId)
            ->whereIn('agreement_id', $agreementIds)
            ->get()
            ->keyBy('agreement_type')
            ->toArray();
    }
}
