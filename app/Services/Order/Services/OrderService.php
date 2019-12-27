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
use App\Exceptions\ServiceException;
use App\Services\Order\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Services\Order\Models\OrderGoods;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
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
                'oid' => $order['id'],
                // todo 即将废弃
                'order_id' => '',
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
                'oid' => $order['id'],
                // todo 即将废弃
                'order_id' => '',
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
                'oid' => $order['id'],
                // todo 即将废弃
                'order_id' => '',
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
    public function findUserNoPaid(string $orderId): array
    {
        return Order::whereUserId(Auth::id())
            ->whereStatus(Order::STATUS_UNPAY)
            ->whereOrderId($orderId)
            ->firstOrFail()->toArray();
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
    public function findUser(string $orderId): array
    {
        return Order::whereUserId(Auth::id())->whereOrderId($orderId)->firstOrFail()->toArray();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function findId(int $id): array
    {
        return Order::whereId($id)->firstOrFail()->toArray();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function findUserId(int $id): array
    {
        return Order::whereId($id)->whereUserId(Auth::id())->firstOrFail()->toArray();
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @throws ServiceException
     */
    public function change2Paying(int $id, array $data): void
    {
        $order = Order::findOrFail($id);
        if ($order->status != Order::STATUS_UNPAY) {
            throw new ServiceException('order status error');
        }
        $data['status'] = Order::STATUS_PAYING;
        $order->update($data);
    }

    /**
     * @param int $id
     *
     * @throws ServiceException
     */
    public function cancel(int $id): void
    {
        $order = Order::findOrFail($id);
        if (! in_array($order->status, [Order::STATUS_PAYING, Order::STATUS_UNPAY])) {
            throw new ServiceException('order status error');
        }
        $order->update(['status' => Order::STATUS_CANCELED]);
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
        $list = $query
            ->with(['goods'])
            ->whereUserId(Auth::id())
            ->latest()
            ->forPage($page, $pageSize)->get()->toArray();

        return compact('total', 'list');
    }

    /**
     * @param int $id
     *
     * @throws ServiceException
     */
    public function changePaid(int $id): void
    {
        $order = Order::findOrFail($id);
        if (! in_array($order->status, [Order::STATUS_PAYING, Order::STATUS_UNPAY])) {
            throw new ServiceException('order status error');
        }
        $order->update(['status' => Order::STATUS_PAID]);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getOrderProducts(int $id): array
    {
        return OrderGoods::where('oid', $id)->get()->toArray();
    }

    /**
     * @param string $date
     *
     * @return array
     */
    public function getTimeoutOrders(string $date): array
    {
        return Order::whereIn('status', [Order::STATUS_UNPAY, Order::STATUS_PAYING])
            ->where('created_at', '<=', $date)
            ->get()->toArray();
    }
}
