<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Order\Services;

use Illuminate\Support\Facades\Auth;
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
     * @return array
     */
    public function userPromoCode(): array
    {
        $code = PromoCode::whereUserId(Auth::id())->first();
        return $code ? $code->toArray() : [];
    }

    /**
     * @param string $code
     * @return array
     */
    public function findCode(string $code): array
    {
        $code = PromoCode::where('code', $code)->first();
        return $code ? $code->toArray() : [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getCurrentUserOrderPaidRecords(int $id): array
    {
        return OrderPaidRecord::whereUserId(Auth::id())
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
        return OrderPaidRecord::whereOrderId($orderId)
            ->where('paid_type', OrderPaidRecord::PAID_TYPE_PROMO_CODE)
            ->get()->toArray();
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getList(array $ids): array
    {
        return PromoCode::whereIn('id', $ids)->get()->toArray();
    }

    /**
     * @param array $ids
     */
    public function decrementUsedTimes(array $ids): void
    {
        foreach ($ids as $id) {
            PromoCode::find($id)->decrement('used_times', 1);
        }
    }

    /**
     * @return array
     */
    public function getCurrentUser(): array
    {
        $code = PromoCode::whereUserId(Auth::id())->first();
        return $code ? $code->toArray() : [];
    }
}
