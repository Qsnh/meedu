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

use PhpZip\ZipFile;
use App\Meedu\Addons;
use GuzzleHttp\Client;
use App\Meedu\MeEduCloud;
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
            if ($action === 'enabled') {
                $lib->enabled($sign);
                $lib->install($sign);
            } elseif ($action === 'disabled') {
                $lib->uninstall($sign);
                $lib->disabled($sign);
            }
            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * @param Addons $lib
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function repository(Request $request, Addons $lib)
    {
        $mc = new MeEduCloud(
            config('meedu.meeducloud.domain'),
            config('meedu.meeducloud.user_id'),
            config('meedu.meeducloud.password')
        );

        try {
            $addons = $mc->addons($request->input('page'), $request->input('size'));
            $addonsData = $addons['data'];

            // 读取已购买的插件
            $buyAddons = [];

            $buyAddons = $mc->userAddons();
            $buyAddons = array_column($buyAddons, null, 'sign');
        } catch (\Exception $e) {
        }

        // 读取本地安装的插件
        $installAddons = $lib->addons();
        $installAddons = array_column($installAddons, null, 'sign');

        foreach ($addonsData as $key => $item) {
            $addonsData[$key]['is_buy'] = isset($buyAddons[$item['sign']]);
            $isInstall = isset($installAddons[$item['sign']]);
            $addonsData[$key]['is_install'] = $isInstall;
            $addonsData[$key]['is_upgrade'] = false;
            if ($isInstall) {
                $addonsData[$key]['is_upgrade'] = version_compare($item['version'], $installAddons[$item['sign']]['version'], '>');
                $addonsData[$key]['local_version'] = $installAddons[$item['sign']]['version'];
            }
        }

        $addons['data'] = $addonsData;

        return $this->successData($addons);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyAddons(Request $request)
    {
        $addonsId = $request->input('addons_id');
        $mc = new MeEduCloud(
            config('meedu.meeducloud.domain'),
            config('meedu.meeducloud.user_id'),
            config('meedu.meeducloud.password')
        );
        try {
            $mc->addonsBuy($addonsId);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * 安装插件
     * @param Request $request
     * @param Addons $lib
     * @return \Illuminate\Http\JsonResponse
     */
    public function installAddons(Request $request, Addons $lib)
    {
        $addonsId = $request->input('addons_id');
        $addonsSign = $request->input('addons_sign');
        $mc = new MeEduCloud(
            config('meedu.meeducloud.domain'),
            config('meedu.meeducloud.user_id'),
            config('meedu.meeducloud.password')
        );
        try {
            // 获取下载url
            $url = $mc->addonsDownloadUrl($addonsId, 0);

            // 下载插件
            $storagePath = storage_path('app/templates/' . $addonsSign . '_' . time() . random_int(0, 100) . '.zip');
            $http = new Client();
            $http->get($url, [
                'sink' => $storagePath,
            ]);

            // 解压
            $zip = new ZipFile();
            $zip->openFile($storagePath)->extractTo(base_path('addons'));

            // 安装命令
            $lib->install($addonsSign);

            // 删除缓存文件
            @unlink($storagePath);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function upgradeAddons(Request $request, Addons $lib)
    {
        $addonsId = $request->input('addons_id');
        $addonsSign = $request->input('addons_sign');
        $mc = new MeEduCloud(
            config('meedu.meeducloud.domain'),
            config('meedu.meeducloud.user_id'),
            config('meedu.meeducloud.password')
        );
        try {
            // 获取下载url
            $url = $mc->addonsDownloadUrl($addonsId, 0);

            // 下载插件
            $storagePath = storage_path('app/templates/' . time() . random_int(0, 100) . '.zip');
            $http = new Client();
            $http->get($url, [
                'sink' => $storagePath,
            ]);

            // 解压
            $zip = new ZipFile();
            $zip->openFile($storagePath)->extractTo(base_path('addons'));

            // 执行升级命令
            $lib->upgrade($addonsSign);

            // 删除缓存文件
            @unlink($storagePath);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $mc = new MeEduCloud(
            config('meedu.meeducloud.domain'),
            config('meedu.meeducloud.user_id'),
            config('meedu.meeducloud.password')
        );
        try {
            $user = $mc->user();

            return $this->successData($user);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
