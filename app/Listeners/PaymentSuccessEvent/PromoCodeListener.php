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
use App\Constant\FrontendConstant;
use App\Events\PaymentSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Member\Services\CreditService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Member\Services\NotificationService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class PromoCodeListener implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @var ConfigService
     */
    protected $configService;

    /**
     * @var CreditService
     */
    protected $creditService;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * PromoCodeListener constructor.
     * @param PromoCodeServiceInterface $promoCodeService
     * @param BusinessState $businessState
     * @param UserServiceInterface $userService
     * @param ConfigServiceInterface $configService
     * @param CreditServiceInterface $creditService
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(
        PromoCodeServiceInterface $promoCodeService,
        BusinessState $businessState,
        UserServiceInterface $userService,
        ConfigServiceInterface $configService,
        CreditServiceInterface $creditService,
        NotificationServiceInterface $notificationService
    ) {
        $this->promoCodeService = $promoCodeService;
        $this->businessState = $businessState;
        $this->userService = $userService;
        $this->configService = $configService;
        $this->creditService = $creditService;
        $this->notificationService = $notificationService;
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

        $orderUser = $this->userService->find($order['user_id']);
        if ($orderUser['invite_user_id'] === 0) {
            // 当前用户使用了优惠码，且没有上级
            // 那么将该优惠码的注册设置为当前用户的上级
            $this->userService->updateInviteUserId($orderUser['id'], $code['user_id'], $code['invite_user_reward']);

            // 邀请积分奖励
            if ($credit1 = $this->configService->getInviteSceneCredit1()) {
                $message = __(FrontendConstant::CREDIT1_REMARK_WATCHED_INVITE);
                $this->creditService->createCredit1Record($code['user_id'], $credit1, $message);
                $this->notificationService->notifyCredit1Message($code['user_id'], $credit1, $message);
            }
        }

        // 记录用户使用invite_promo_code的状态
        // 每个用户只能只能使用一次其它用户的邀请码
        if ($orderUser['is_used_promo_code'] !== FrontendConstant::YES) {
            $this->userService->setUsedPromoCode($orderUser['id']);
        }
    }
}
