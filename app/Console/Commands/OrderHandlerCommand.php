<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Businesses\BusinessState;
use App\Events\PaymentSuccessEvent;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Interfaces\OrderServiceInterface;

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
    protected $description = '订单改为已支付';

    /**
     * @var OrderService
     */
    protected $orderService;

    protected $businessState;

    /**
     * OrderHandlerCommand constructor.
     *
     * @param OrderServiceInterface $orderService
     * @param BusinessState $businessState
     */
    public function __construct(OrderServiceInterface $orderService, BusinessState $businessState)
    {
        parent::__construct();
        $this->orderService = $orderService;
        $this->businessState = $businessState;
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $order = $this->orderService->findOrFail($orderId);
        if ($this->businessState->orderIsPaid($order)) {
            $this->warn('order has paid.');

            return;
        }

        event(new PaymentSuccessEvent($order));
        $this->line('success');
    }
}
