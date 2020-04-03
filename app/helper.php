<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

if (!function_exists('flash')) {
    function flash($message, $level = 'warning')
    {
        $message = new \Illuminate\Support\MessageBag([$level => $message]);
        request()->session()->flash($level, $message);
    }
}

if (!function_exists('get_first_flash')) {
    /**
     * 获取第一条FLASH信息.
     *
     * @param $level
     *
     * @return mixed|string
     */
    function get_first_flash($level)
    {
        if ($level === 'error' && session('errors') && session('errors')->any()) {
            return session('errors')->all()[0];
        }
        if (!session()->has($level)) {
            return '';
        }

        return session($level)->first();
    }
}
if (!function_exists('menu_active')) {
    /**
     * @param $routeName
     *
     * @return bool
     */
    function menu_active($routeName)
    {
        return request()->routeIs($routeName) ? 'active' : '';
    }
}

if (!function_exists('exception_record')) {
    /**
     * 记录异常.
     *
     * @param Exception $exception
     */
    function exception_record(Exception $exception): void
    {
        $request = request();
        $data = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'code' => $exception->getCode(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'params' => $request->all(),
            'url' => $request->url(),
            'method' => $request->method(),
            'ip' => $request->getClientIps(),
        ];
        \Log::error('exception', $data);
    }
}

if (!function_exists('markdown_to_html')) {
    /**
     * markdown转换为html.
     *
     * @param $content
     *
     * @return string
     */
    function markdown_to_html($content)
    {
        $content = (new Parsedown())->setBreaksEnabled(true)->parse($content);
        $content = clean($content);
        $content = preg_replace('#<table>#', '<table class="table table-hover table-bordered">', $content);

        return $content;
    }
}

if (!function_exists('aliyun_play_auth')) {
    /**
     * 获取阿里云视频的播放Auth.
     *
     * @param \App\Models\Video $video
     *
     * @return mixed|SimpleXMLElement
     */
    function aliyun_play_auth($video)
    {
        try {
            $client = aliyun_sdk_client();
            $request = new \vod\Request\V20170321\GetVideoPlayAuthRequest();
            $request->setAcceptFormat('JSON');
            $request->setRegionId(config('meedu.upload.video.aliyun.region', ''));
            $request->setVideoId($video['aliyun_video_id']);
            $response = $client->getAcsResponse($request);

            return $response->PlayAuth;
        } catch (Exception $exception) {
            exception_record($exception);

            return '';
        }
    }
}

if (!function_exists('aliyun_play_url')) {
    /**
     * 获取阿里云的视频播放地址
     * @param $vid
     * @return array
     */
    function aliyun_play_url($vid)
    {
        try {
            $client = aliyun_sdk_client();
            $request = new \vod\Request\V20170321\GetPlayInfoRequest();
            $request->setVideoId($vid);
            $request->setAuthTimeout(3600 * 3);
            $request->setAcceptFormat('JSON');
            $response = $client->getAcsResponse($request);
            $list = $response->PlayInfoList->PlayInfo;
            $rows = [];
            foreach ($list as $item) {
                $rows[] = [
                    'format' => $item->Format,
                    'url' => $item->PlayURL,
                    'duration' => $item->Duration,
                ];
            }

            return $rows;
        } catch (Exception $exception) {
            exception_record($exception);

            return [];
        }
    }
}

if (!function_exists('aliyun_sdk_client')) {
    /**
     * @return DefaultAcsClient
     */
    function aliyun_sdk_client()
    {
        $profile = \DefaultProfile::getProfile(
            config('meedu.upload.video.aliyun.region', ''),
            config('meedu.upload.video.aliyun.access_key_id', ''),
            config('meedu.upload.video.aliyun.access_key_secret', '')
        );
        return new \DefaultAcsClient($profile);
    }
}

if (!function_exists('v')) {
    /**
     * 重写视图.
     *
     * @param $viewName
     * @param array $params
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function v($viewName, $params = [])
    {
        $namespace = config('meedu.system.theme.use', 'default');
        $viewName = preg_match('/::/', $viewName) ? $viewName : $namespace . '::' . $viewName;
        is_h5() && $viewName = str_replace('frontend', 'h5', $viewName);

        return view($viewName, $params);
    }
}

if (!function_exists('is_h5')) {
    /**
     * @return bool
     */
    function is_h5()
    {
        return (new Mobile_Detect())->isMobile();
    }
}

if (!function_exists('is_wechat')) {
    /**
     * @return bool
     */
    function is_wechat()
    {
        if (strpos(request()->server('HTTP_USER_AGENT'), 'MicroMessenger')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('duration_humans')) {
    /**
     * @param $duration
     *
     * @return string
     */
    function duration_humans($duration)
    {
        $minute = intdiv($duration, 60);
        $second = $duration % 60;
        if ($minute >= 60) {
            $hours = intdiv($minute, 60);
            $minute %= 60;

            return sprintf('%02d:%02d:%02d', $hours, $minute, $second);
        }

        return $minute ? sprintf('%02d:%02d', $minute, $second) : sprintf('00:%02d', $second);
    }
}

if (!function_exists('enabled_socialites')) {
    /**
     * 获取已启用的第三方登录.
     *
     * @return \Illuminate\Support\Collection
     */
    function enabled_socialites()
    {
        $socialites = config('meedu.member.socialite', []);
        $enabled = collect($socialites)->filter(function ($item) {
            return (int)$item['enabled'] === 1;
        });

        return $enabled;
    }
}

if (!function_exists('get_payment_scene')) {
    /**
     * @return string
     */
    function get_payment_scene()
    {
        if (is_wechat()) {
            return \App\Constant\FrontendConstant::PAYMENT_SCENE_WECHAT_OPEN;
        }
        $scene = is_h5() ? \App\Constant\FrontendConstant::PAYMENT_SCENE_H5 : \App\Constant\FrontendConstant::PAYMENT_SCENE_PC;
        return $scene;
    }
}

if (!function_exists('get_payments')) {
    /**
     * @param $scene
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function get_payments($scene)
    {
        /**
         * @var \App\Services\Base\Services\ConfigService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
        $payments = collect($configService->getPayments())->filter(function ($payment) use ($scene) {
            $enabled = (int)$payment['enabled'] === 1;
            $isSet = $payment[$scene] ?? false;

            return $enabled && $isSet;
        });

        return $payments;
    }
}

if (!function_exists('get_at_users')) {
    /**
     * @param string $content
     * @return array
     */
    function get_at_users(string $content): array
    {
        preg_match_all('/@(.*?)\s{1}/', $content, $result);
        if (count($result[1] ?? []) === 0) {
            return [];
        }
        return $result[1];
    }
}

if (!function_exists('array_compress')) {
    /**
     * @param array $arr
     * @param string $prevKey
     * @return array
     */
    function array_compress(array $arr, string $prevKey = ''): array
    {
        $rows = [];
        foreach ($arr as $key => $item) {
            $tmpKey = ($prevKey ? $prevKey . '.' : '') . $key;
            if (is_array($item)) {
                $rows = array_merge($rows, array_compress($item, $tmpKey));
            } else {
                $rows[$tmpKey] = $item;
            }
        }
        return $rows;
    }
}

if (!function_exists('random_number')) {
    /**
     * @param $prefix
     * @param $length
     * @return string
     * @throws Exception
     */
    function random_number($prefix, $length): string
    {
        $prefixLength = mb_strlen($prefix);
        $length -= $prefixLength;
        for ($i = 0; $i < $length; $i++) {
            $prefix .= random_int(0, 9);
        }
        return $prefix;
    }
}

if (!function_exists('arr1_clear')) {
    /**
     * @param $arr
     * @param $columns
     * @return array
     */
    function arr1_clear($arr, $columns)
    {
        return \Illuminate\Support\Arr::only($arr, $columns);
    }
}

if (!function_exists('arr2_clear')) {
    /**
     * @param $arr
     * @param $columns
     * @param bool $rec
     * @return array
     */
    function arr2_clear($arr, $columns, $rec = false)
    {
        return array_map(function ($item) use ($columns, $rec) {
            if (!$rec) {
                return \Illuminate\Support\Arr::only($item, $columns);
            }
            return array_map(function ($item) use ($columns) {
                return \Illuminate\Support\Arr::only($item, $columns);
            }, $item);
        }, $arr);
    }
}

if (!function_exists('get_tencent_play_url')) {
    function get_tencent_play_url(string $vid): array
    {
        try {
            /**
             * @var $configService \App\Services\Base\Services\ConfigService
             */
            $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
            $config = $configService->getTencentVodConfig();
            $credential = new \TencentCloud\Common\Credential($config['secret_id'], $config['secret_key']);
            $client = new \TencentCloud\Vod\V20180717\VodClient($credential, '');
            $req = new \TencentCloud\Vod\V20180717\Models\DescribeMediaInfosRequest();
            $req->FileIds[] = $vid;
            $req->Filters = ['basicInfo'];
            /**
             * @var $response \TencentCloud\Vod\V20180717\Models\DescribeMediaInfosResponse
             */
            $response = $client->DescribeMediaInfos($req);
            if (!$response->MediaInfoSet) {
                return [];
            }
            /**
             * @var $mediaBasicInfo \TencentCloud\Vod\V20180717\Models\MediaBasicInfo
             */
            $mediaBasicInfo = $response->MediaInfoSet[0]->BasicInfo;
            return [
                [
                    'format' => $mediaBasicInfo->Type,
                    'url' => $mediaBasicInfo->MediaUrl,
                    'duration' => 0,
                ]
            ];
        } catch (Exception $exception) {
            exception_record($exception);

            return [];
        }
    }
}
