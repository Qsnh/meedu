<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class PaymentController extends FrontendController
{
    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param $payment
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function callback($payment)
    {
        $payments = $this->configService->getPayments();
        if (!isset($payments[$payment])) {
            abort(404);
        }
        $handler = $payments[$payment]['handler'];

        return app()->make($handler)->callback();
    }
}
