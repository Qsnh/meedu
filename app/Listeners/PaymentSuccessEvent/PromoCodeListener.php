<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\PaymentSuccessEvent;

use App\Businesses\BusinessState;
use App\Events\PaymentSuccessEvent;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class PromoCodeListener
{

    /**
     * @var PromoCodeService
     */
    protected $promoCodeService;
    protected $businessState;
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * PromoCodeListener constructor.
     * @param PromoCodeServiceInterface $promoCodeService
     * @param BusinessState $businessState
     * @param UserServiceInterface $userService
     */
    public function __construct(
        PromoCodeServiceInterface $promoCodeService,
        BusinessState $businessState,
        UserServiceInterface $userService
    ) {
        $this->promoCodeService = $promoCodeService;
        $this->businessState = $businessState;
        $this->userService = $userService;
    }

    /**
     * @param PaymentSuccessEvent $event
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle(PaymentSuccessEvent $event)
    {
        $order = $event->order;
        $promoCodeOrderPaidRecords = $this->promoCodeService->getOrderPaidRecords($order['id']);
        if (!$promoCodeOrderPaidRecords) {
            return;
        }
        $promoCodes = $this->promoCodeService->getList(array_column($promoCodeOrderPaidRecords, 'paid_type_id'));
        if (!$promoCodes) {
            return;
        }
        $code = [];
        foreach ($promoCodes as $promoCode) {
            if ($this->businessState->isUserInvitePromoCode($promoCode['code'])) {
                $code = $promoCode;
                break;
            }
        }
        if (!$code) {
            return;
        }

        // 修改用户上级
        $orderUser = $this->userService->find($order['user_id']);
        if ($orderUser['invite_user_id'] === 0) {
            $this->userService->updateInviteUserId($orderUser['id'], $code);
        }
    }
}
