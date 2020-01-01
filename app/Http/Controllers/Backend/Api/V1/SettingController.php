<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Meedu\Setting;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    public function index()
    {
        $config = [
            'meedu' => config('meedu'),
            'sms' => config('sms'),
            'services' => config('services'),
            'pay' => config('pay'),
            'eshanghu' => config('eshanghu'),
            'tencent' => config('tencent'),
            'filesystems' => config('filesystems'),
        ];

        return $this->successData($config);
    }

    public function saveHandler(Request $request)
    {
        app()->make(Setting::class)->save($request);

        return $this->success();
    }
}
