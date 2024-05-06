<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Order\Services;

use App\Services\Order\Models\PromoCode;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class PromoCodeService implements PromoCodeServiceInterface
{
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    public function userCreate(array $user): void
    {
        $inviteConfig = $this->configService->getMemberInviteConfig();
        $data = [
            'user_id' => $user['id'],
            'code' => random_number('U' . $user['id'], 10),
            'invite_user_reward' => $inviteConfig['invite_user_reward'],
            'invited_user_reward' => $inviteConfig['invited_user_reward'],
        ];
        PromoCode::create($data);
    }

    public function userPromoCode(int $userId): array
    {
        $code = PromoCode::query()->where('user_id', $userId)->first();
        return $code ? $code->toArray() : [];
    }

    public function findCode(string $code): array
    {
        $code = PromoCode::query()->where('code', $code)->first();
        return $code ? $code->toArray() : [];
    }

    public function getCurrentUserOrderPaidRecords(int $userId, int $id): array
    {
        return OrderPaidRecord::query()
            ->where('user_id', $userId)
            ->where('paid_type', OrderPaidRecord::PAID_TYPE_PROMO_CODE)
            ->where('paid_type_id', $id)
            ->get()->toArray();
    }

    public function getOrderPaidRecords(int $orderId): array
    {
        return OrderPaidRecord::query()
            ->where('order_Id', $orderId)
            ->where('paid_type', OrderPaidRecord::PAID_TYPE_PROMO_CODE)
            ->get()->toArray();
    }

    public function getList(array $ids): array
    {
        return PromoCode::query()->whereIn('id', $ids)->get()->toArray();
    }

    public function decrementUsedTimes(array $ids): void
    {
        foreach ($ids as $id) {
            PromoCode::query()->where('id', $id)->decrement('used_times', 1);
        }
    }
    
    public function getUserPromoCode(int $userId): array
    {
        $code = PromoCode::query()->where('user_id', $userId)->first();
        return $code ? $code->toArray() : [];
    }
}
