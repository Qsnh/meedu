<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories;

use Exception;
use App\Models\Order;
use App\Models\OrderGoods;
use Illuminate\Support\Facades\DB;
use App\Notifications\SimpleMessageNotification;

class RoleRepository
{
    public $errors = '';

    public function bulHandler($user, $role)
    {
        if ($user->credit1 < $role->charge) {
            $this->errors = '余额不足';

            return false;
        }

        if (
            $user->role &&
            strtotime($user->role_expired_at) > time() &&
            $user->role->weight != $role->weight
        ) {
            $this->errors = '您的账户下面已经有会员啦';

            return false;
        }

        DB::beginTransaction();
        try {
            // 创建订单记录
            $order = $user->orders()->save(new Order([
                'goods_id' => $role->id,
                'goods_type' => Order::GOODS_TYPE_ROLE,
                'charge' => $role->charge,
                'status' => Order::STATUS_PAID,
            ]));
            // 扣除余额
            $user->credit1Dec($role->charge);
            // 购买会员
            $user->buyRole($role);
            // 消息通知
            $user->notify(new SimpleMessageNotification($order->getNotificationContent()));

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            $this->errors = '系统错误';

            return false;
        }
    }

    public function createOrder($user, $role)
    {
        if (
            $user->role &&
            strtotime($user->role_expired_at) > time() &&
            $user->role->weight != $role->weight
        ) {
            $this->errors = '您的账户下面已经有会员啦';

            return false;
        }

        DB::beginTransaction();
        try {
            // 创建订单
            $order = $user->orders()->save(new Order([
                'order_id' => gen_order_no($user),
                'charge' => $role->charge,
                'status' => Order::STATUS_UNPAY,
            ]));
            // 关联商品
            $order->goods()->save(new OrderGoods([
                'user_id' => $user->id,
                'goods_id' => $role->id,
                'goods_type' => OrderGoods::GOODS_TYPE_ROLE,
                'num' => 1,
                'charge' => $role->charge,
            ]));

            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            $this->errors = '系统错误';

            return false;
        }
    }
}
