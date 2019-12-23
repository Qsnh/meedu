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

use Illuminate\Console\Command;
use App\Events\PaymentSuccessEvent;
use App\Services\Order\Services\OrderService;

class OrderHandlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:success {order_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'order handler tool.';

    protected $orderService;

    /**
     * OrderHandlerCommand constructor.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $order = $this->orderService->findWithoutScope($orderId);

        event(new PaymentSuccessEvent($order));
        $this->line('success');
    }
}
