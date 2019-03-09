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
use App\Models\Order;
use Illuminate\Console\Command;

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
        $limit = 1800;
        $now = Carbon::now()->addSecond($limit);
        $orders = Order::whereIn('status', [Order::STATUS_PAYING, Order::STATUS_UNPAY])->where('created_at', '<=', $now)->get();
        if ($orders->isEmpty()) {
            return;
        }
        foreach ($orders as $order) {
            $this->line($order->order_id);
            $order->status = Order::STATUS_CANCELED;
            $order->save();
        }
    }
}
