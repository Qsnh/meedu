<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

class PaymentController extends FrontendController
{
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
