<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Businesses;

use App\Constant\FrontendConstant;

class BusinessState
{
    public function canSeeVideo($user, array $course, array $video): bool
    {
        return false;
        // todo
        if ($video['charge'] == 0) {
            return true;
        }
    }

    /**
     * 订单是否支付
     *
     * @param array $order
     * @return bool
     */
    public function orderIsPaid(array $order): bool
    {
        return $order['status'] == FrontendConstant::ORDER_PAID;
    }
}
