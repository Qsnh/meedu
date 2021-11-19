<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Order\Services;

use App\Services\Order\Models\PromoCode;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class PromoCodeService implements PromoCodeServiceInterface
{

    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param array $user
     */
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

    /**
     * @param int $userId
     * @return array
     */
    public function userPromoCode(int $userId): array
    {
        $code = PromoCode::query()->where('user_id', $userId)->first();
        return $code ? $code->toArray() : [];
    }

    /**
     * @param string $code
     * @return array
     */
    public function findCode(string $code): array
    {
        $code = PromoCode::query()->where('code', $code)->first();
        return $code ? $code->toArray() : [];
    }

    /**
     * @param int $userId
     * @param int $id
     * @return array
     */
    public function getCurrentUserOrderPaidRecords(int $userId, int $id): array
    {
        return OrderPaidRecord::query()
            ->where('user_id', $userId)
            ->where('paid_type', OrderPaidRecord::PAID_TYPE_PROMO_CODE)
            ->where('paid_type_id', $id)
            ->get()->toArray();
    }

    /**
     * @param int $orderId
     * @return array
     */
    public function getOrderPaidRecords(int $orderId): array
    {
        return OrderPaidRecord::query()
            ->where('order_Id', $orderId)
            ->where('paid_type', OrderPaidRecord::PAID_TYPE_PROMO_CODE)
            ->get()->toArray();
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getList(array $ids): array
    {
        return PromoCode::query()->whereIn('id', $ids)->get()->toArray();
    }

    /**
     * @param array $ids
     */
    public function decrementUsedTimes(array $ids): void
    {
        foreach ($ids as $id) {
            PromoCode::query()->where('id', $id)->decrement('used_times', 1);
        }
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserPromoCode(int $userId): array
    {
        $code = PromoCode::query()->where('user_id', $userId)->first();
        return $code ? $code->toArray() : [];
    }
}
