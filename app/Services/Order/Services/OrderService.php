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

use Illuminate\Support\Facades\DB;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\OrderGoods;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Models\scopes\UserScope;

class OrderService
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param int   $userId
     * @param array $course
     *
     * @return mixed
     */
    public function createCourseOrder(int $userId, array $course): array
    {
        return DB::transaction(function () use ($userId, $course) {
            $order = Order::create([
                'user_id' => $userId,
                'charge' => $course['charge'],
                'status' => Order::STATUS_UNPAY,
                'order_id' => $this->genOrderNo($userId, OrderGoods::GOODS_TYPE_COURSE),
            ]);
            OrderGoods::create([
                'user_id' => $userId,
                'order_id' => $order['id'],
                'num' => 1,
                'charge' => $course['charge'],
                'goods_id' => $course['id'],
                'goods_type' => OrderGoods::GOODS_TYPE_COURSE,
            ]);

            return $order->toArray();
        });
    }

    /**
     * @param int   $userId
     * @param array $video
     *
     * @return mixed
     */
    public function createVideoOrder(int $userId, array $video): array
    {
        return DB::transaction(function () use ($userId, $video) {
            $order = Order::create([
                'user_id' => $userId,
                'charge' => $video['charge'],
                'status' => Order::STATUS_UNPAY,
                'order_id' => $this->genOrderNo($userId, OrderGoods::GOODS_TYPE_VIDEO),
            ]);
            OrderGoods::create([
                'user_id' => $userId,
                'order_id' => $order['id'],
                'num' => 1,
                'charge' => $video['charge'],
                'goods_id' => $video['id'],
                'goods_type' => OrderGoods::GOODS_TYPE_VIDEO,
            ]);

            return $order->toArray();
        });
    }

    /**
     * @param int   $userId
     * @param array $role
     *
     * @return mixed
     */
    public function createRoleOrder(int $userId, array $role): array
    {
        return DB::transaction(function () use ($userId, $role) {
            $order = Order::create([
                'user_id' => $userId,
                'charge' => $role['charge'],
                'status' => Order::STATUS_UNPAY,
                'order_id' => $this->genOrderNo($userId, OrderGoods::GOODS_TYPE_ROLE),
            ]);
            OrderGoods::create([
                'user_id' => $userId,
                'order_id' => $order['id'],
                'num' => 1,
                'charge' => $role['charge'],
                'goods_id' => $role['id'],
                'goods_type' => OrderGoods::GOODS_TYPE_ROLE,
            ]);

            return $order->toArray();
        });
    }

    /**
     * @param int    $userId
     * @param string $type
     *
     * @return string
     */
    protected function genOrderNo(int $userId, string $type): string
    {
        $time = date('His');
        $rand = mt_rand(10, 99);

        return strtolower($type).$userId.$time.$rand;
    }

    /**
     * @param string $orderId
     *
     * @return array
     */
    public function findNoPaid(string $orderId): array
    {
        return Order::whereStatus(Order::STATUS_UNPAY)->whereOrderId($orderId)->firstOrFail()->toArray();
    }

    /**
     * @param string $orderId
     *
     * @return array
     */
    public function find(string $orderId): array
    {
        return Order::whereOrderId($orderId)->firstOrFail()->toArray();
    }

    /**
     * @param string $orderId
     *
     * @return array
     */
    public function findWithoutScope(string $orderId): array
    {
        return Order::withoutGlobalScope(UserScope::class)->whereOrderId($orderId)->firstOrFail()->toArray();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function findWithoutScopeById(int $id): array
    {
        return Order::withoutGlobalScope(UserScope::class)->whereId($id)->firstOrFail()->toArray();
    }

    /**
     * @param int   $id
     * @param array $data
     */
    public function change2Paying(int $id, array $data): void
    {
        $data['status'] = Order::STATUS_PAYING;
        Order::whereId($id)->update($data);
    }

    /**
     * @param int $orderId
     */
    public function cancel(int $orderId): void
    {
        Order::whereId($orderId)->update(['status' => Order::STATUS_CANCELED]);
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return array
     */
    public function userOrdersPaginate(int $page, int $pageSize): array
    {
        $query = Order::query();
        $total = $query->count();
        $list = $query->with(['goods'])->orderByDesc('created_at')->forPage($page, $pageSize)->get()->toArray();

        return compact('total', 'list');
    }

    /**
     * @param int $id
     */
    public function changePaid(int $id): void
    {
        $order = $this->findWithoutScopeById($id);
        if ($order['status'] != Order::STATUS_PAYING) {
            return;
        }
        Order::whereId($id)->update(['status' => Order::STATUS_PAID]);
    }

    /**
     * @param int $orderId
     *
     * @return array
     */
    public function getOrderProducts(int $orderId): array
    {
        return OrderGoods::whereOrderId($orderId)->get()->toArray();
    }
}
