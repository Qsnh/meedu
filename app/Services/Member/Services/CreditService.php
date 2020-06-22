<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCreditRecord;
use App\Services\Member\Interfaces\CreditServiceInterface;

class CreditService implements CreditServiceInterface
{
    public function createCredit1Record(int $userId, int $sum, string $remark = ''): void
    {
        DB::transaction(function () use ($userId, $sum, $remark) {
            // 积分扣除
            User::query()
                ->where('id', $userId)
                ->increment(UserCreditRecord::FIELD_CREDIT1, $sum);

            UserCreditRecord::create([
                'user_id' => $userId,
                'sum' => $sum,
                'remark' => $remark,
                'field' => UserCreditRecord::FIELD_CREDIT1,
            ]);
        });
    }

    public function getCredit1RecordsPaginate(int $userId, int $page, int $pageSize): array
    {
        return UserCreditRecord::query()
            ->where('user_id', $userId)
            ->where('field', UserCreditRecord::FIELD_CREDIT1)
            ->forPage($page, $pageSize)
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }

    public function getCredit1RecordsCount(int $userId): int
    {
        return UserCreditRecord::query()
            ->where('user_id', $userId)
            ->where('field', UserCreditRecord::FIELD_CREDIT1)
            ->count();
    }
}
