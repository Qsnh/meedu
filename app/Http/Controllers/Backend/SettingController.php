<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $config = [
            'meedu' => config('meedu'),
            'sms' => config('sms'),
            'services' => config('services'),
        ];

        return view('backend.setting.index', compact('config'));
    }

    public function saveHandler(Request $request)
    {
        $rows = [];
        foreach ($request->all() as $index => $item) {
            if (! preg_match('/\*/', $index)) {
                continue;
            }
            $index = str_replace('*', '.', $index);
            $rows[$index] = $item;
        }
        file_put_contents(config('meedu.save'), json_encode($rows));
        flash('修改成功', 'success');

        return back();
    }
}
