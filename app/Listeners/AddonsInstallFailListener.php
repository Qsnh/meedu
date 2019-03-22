<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners;

use App\Models\Addons;
use Illuminate\Support\Facades\DB;
use App\Events\AddonsInstallFailEvent;

class AddonsInstallFailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param AddonsInstallFailEvent $event
     */
    public function handle(AddonsInstallFailEvent $event)
    {
        $addons = $event->addons;

        DB::beginTransaction();
        try {
            // 修改状态
            $addons->update(['status' => Addons::STATUS_FAIL]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
        }
    }
}
