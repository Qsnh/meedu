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

class VideoRepository
{
    public function createOrder($user, $video)
    {
        if ($user->buyVideos()->whereId($video->id)->exists()) {
            return '您已经购买过本视频啦';
        }

        DB::beginTransaction();
        try {
            // 创建订单
            $order = $user->orders()->save(new Order([
                'order_id' => gen_order_no($user),
                'charge' => $video->charge,
                'status' => Order::STATUS_UNPAY,
            ]));
            // 关联商品
            $order->goods()->save(new OrderGoods([
                'user_id' => $user->id,
                'goods_id' => $video->id,
                'goods_type' => OrderGoods::GOODS_TYPE_VIDEO,
                'num' => 1,
                'charge' => $video->charge,
            ]));

            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('购买失败', 'warning');

            return '系统出错';
        }
    }
}
