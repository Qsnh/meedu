<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Interfaces\OrderServiceInterface;
use Symfony\Component\Console\Command\Command as CommandAlias;

class OrderTimeoutHandlerCommand extends Command
{
    protected $signature = 'order:pay:timeout';

    protected $description = '订单超时处理（自动置为已取消=无法继续支付）';

    /**
     * @var OrderService
     */
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }


    public function handle()
    {
        $now = Carbon::now()->subMinutes(60);
        $orders = $this->orderService->getTimeoutOrders($now->toDateTimeString());
        if (!$orders) {
            return CommandAlias::SUCCESS;
        }

        foreach ($orders as $order) {
            $this->line($order['order_id']);
            $this->orderService->cancel($order['id']);
        }

        return CommandAlias::SUCCESS;
    }
}
