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

use Exception;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Notifications\SimpleMessageNotification;

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

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $order = Order::whereOrderId($orderId)->first();
        if (! $order) {
            $this->warn('订单不存在');

            return;
        }
        if ($order->status == Order::STATUS_PAID) {
            $this->warn('该订单已支付');

            return;
        }

        DB::beginTransaction();
        try {
            // 修改订单状态
            $order->status = Order::STATUS_PAID;
            $order->save();

            // 商品归属
            $order->user->handlerOrderSuccess($order);

            // 消息通知
            $order->user->notify(new SimpleMessageNotification($order->getNotificationContent()));

            DB::commit();

            $this->line('处理成功');
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            $this->warn($exception->getMessage());
        }
    }
}
