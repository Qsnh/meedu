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

use App\User;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderGoods;
use Illuminate\Support\Facades\DB;

class BookRepository
{
    public function createOrder(User $user, Book $book)
    {
        if ($user->books()->whereId($book->id)->exists()) {
            return '电子书已经购买啦';
        }

        DB::beginTransaction();
        try {
            // 创建订单
            $order = $user->orders()->save(new Order([
                'charge' => $book->charge,
                'status' => Order::STATUS_UNPAY,
                'order_id' => gen_order_no($user),
            ]));
            // 关联商品
            $order->goods()->save(new OrderGoods([
                'user_id' => $user->id,
                'num' => 1,
                'charge' => $book->charge,
                'goods_id' => $book->id,
                'goods_type' => OrderGoods::GOODS_TYPE_BOOK,
            ]));

            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);

            return '系统出错';
        }
    }
}
