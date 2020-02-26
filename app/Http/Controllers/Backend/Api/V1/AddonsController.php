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

use App\Meedu\Addons;
use Illuminate\Http\Request;

class AddonsController extends BaseController
{
    public function index(Addons $lib)
    {
        $addons = $lib->addons();
        $loadedProviders = $lib->getProvidersMap();
        $loadedProvidersMap = [];
        foreach ($loadedProviders as $val) {
            $arr = explode('\\', $val);
            $loadedProvidersMap[$arr[2]][] = $val;
        }

        $addons = array_map(function ($item) use ($loadedProvidersMap) {
            $item['index_url'] = '';
            $item['enabled'] = isset($loadedProvidersMap[$item['sign']]);
            try {
                $indexRoute = $item['index_route'] ?? '';
                $indexRoute && $item['index_url'] = route($indexRoute);
                return $item;
            } catch (\Exception $e) {
                return $item;
            }
        }, $addons);

        return $this->successData(array_values($addons));
    }

    /**
     * @param Request $request
     * @param Addons $lib
     * @return \Illuminate\Http\JsonResponse
     */
    public function switchHandler(Request $request, Addons $lib)
    {
        $sign = $request->input('sign');
        $action = $request->input('action');
        try {
            if ($action == 'enabled') {
                $lib->enabled($sign);
            } elseif ($action == 'disabled') {
                $lib->disabled($sign);
            }
            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
