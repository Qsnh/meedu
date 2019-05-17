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

use App\Meedu\Addons;
use App\Http\Controllers\Controller;

class AddonsController extends Controller
{
    public function index(Addons $lib)
    {
        $addons = $lib->addons();
        return view('backend.addons.index', compact('addons'));
    }

    public function generateProvidersMap(Addons $lib)
    {
        $lib->reGenProvidersMap();
        flash('成功成功', 'success');
        return back();
    }
}
