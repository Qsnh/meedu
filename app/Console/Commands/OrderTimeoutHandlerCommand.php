<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderTimeoutHandlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:pay:timeout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order pay timeout.';

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * OrderTimeoutHandlerCommand constructor.
     *
     * @param OrderServiceInterface $orderService
     */
    public function __construct(OrderServiceInterface $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    /**
     * @throws \App\Exceptions\ServiceException
     */
    public function handle()
    {
        // 超时一个小时未支付订单
        $now = Carbon::now()->subMinutes(60);
        $orders = $this->orderService->getTimeoutOrders($now->toDateTimeString());
        if (!$orders) {
            return;
        }
        foreach ($orders as $order) {
            $this->line($order['order_id']);
            $this->orderService->cancel($order['id']);
        }
    }
}
