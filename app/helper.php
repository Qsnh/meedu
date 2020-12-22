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
            'code' => $exception->getCode(),
            'line' => $exception->getLine(),
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
     * 获取阿里云视频的播放Auth
     *
     * @param $video
     * @param bool $isTry
     * @return mixed|string
     */
    function aliyun_play_auth($video, $isTry = false)
    {
        // 试看参数封装
        $playConfig = [];
        ($isTry && $video['free_seconds'] > 0) && $playConfig['PreviewTime'] = $video['free_seconds'];
        try {
            aliyun_sdk_client();

            $query = ['VideoId' => $video['aliyun_video_id']];
            $playConfig && $query['PlayConfig'] = json_encode($playConfig);

            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->product('Vod')
                ->version('2017-03-21')
                ->action('GetVideoPlayAuth')
                ->options([
                    'query' => $query,
                ])
                ->request();

            return $result['PlayAuth'];
        } catch (Exception $exception) {
            exception_record($exception);

            return '';
        }
    }
}

if (!function_exists('aliyun_play_url')) {
    /**
     * 获取阿里云的视频播放地址
     * @param array $video
     * @param bool $isTry
     * @return array
     */
    function aliyun_play_url(array $video, $isTry = false)
    {
        try {
            aliyun_sdk_client();

            $playConfig = [];
            ($isTry && $video['free_seconds'] > 0) && $playConfig['PreviewTime'] = $video['free_seconds'];

            $query = ['VideoId' => $video['aliyun_video_id']];
            $playConfig && $query['PlayConfig'] = json_encode($playConfig);
            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->product('Vod')
                ->version('2017-03-21')
                ->action('GetPlayInfo')
                ->options([
                    'query' => $query,
                ])
                ->request();

            $playInfo = $result['PlayInfoList']['PlayInfo'];
            $rows = [];
            foreach ($playInfo as $item) {
                $rows[] = [
                    'format' => $item['Format'],
                    'url' => $item['PlayURL'],
                    'duration' => $item['Duration'],
                    'name' => $item['Height'],
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
    function aliyun_sdk_client()
    {
        /**
         * @var \App\Services\Base\Services\ConfigService $configService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
        $aliyunVodConfig = $configService->getAliyunVodConfig();
        \AlibabaCloud\Client\AlibabaCloud::accessKeyClient($aliyunVodConfig['access_key_id'], $aliyunVodConfig['access_key_secret'])
            ->regionId($aliyunVodConfig['region'])
            ->connectTimeout(3)
            ->timeout(30)
            ->asDefaultClient();
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
            $req->SubAppId = (int)$config['app_id'];
            /**
             * @var $response \TencentCloud\Vod\V20180717\Models\DescribeMediaInfosResponse
             */
            $response = $client->DescribeMediaInfos($req);
            if (!$response->MediaInfoSet) {
                // 无法获取url地址
                return [];
            }
            if ($response->MediaInfoSet[0]->TranscodeInfo) {
                // 配置了转码信息
                $urls = [];
                foreach ($response->MediaInfoSet[0]->TranscodeInfo->TranscodeSet as $item) {
                    $url = $item->Url;
                    $format = pathinfo($url, PATHINFO_EXTENSION);
                    $urls[] = [
                        'url' => $url,
                        'format' => $format,
                        'Duration' => (int)$item->Duration,
                        'name' => $item->Height,
                    ];
                }
                return $urls;
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
                    'name' => '',
                ]
            ];
        } catch (Exception $exception) {
            exception_record($exception);

            return [];
        }
    }
}

if (!function_exists('get_play_url')) {
    /**
     * 获取播放地址
     * @param array $video
     * @param bool $isTry
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function get_play_url(array $video, $isTry = false)
    {
        $playUrl = [];
        if ($video['aliyun_video_id']) {
            $playUrl = aliyun_play_url($video, $isTry);
        } elseif ($video['tencent_video_id']) {
            $playUrl = get_tencent_play_url($video['tencent_video_id']);
            // 是否开启了播放key
            if ($key = config('meedu.system.player.tencent_play_key')) {
                $tencentKey = app()->make(\App\Meedu\Player\TencentKey::class);
                $playUrl = array_map(function ($item) use ($tencentKey, $isTry, $video) {
                    $item['url'] = $tencentKey->url($item['url'], $isTry, $video);
                    return $item;
                }, $playUrl);
            }
        } else {
            $playUrl[] = [
                'url' => $video['url'],
                'format' => pathinfo($video['url'], PATHINFO_EXTENSION),
                'name' => '',
                'duration' => 0,
            ];
        }

        if (count($playUrl) > 1) {
            // 可播放数量大于1，说明配置了转码，那么需要删除第一条数据
            // 因为该条数据是原始的视频内容，不安全，未加密等等
            unset($playUrl[0]);
        }

        sort($playUrl);

        return collect($playUrl);
    }
}

if (!function_exists('is_dev')) {
    /**
     * @return bool|string
     */
    function is_dev()
    {
        return app()->environment(['dev', 'local']);
    }
}

if (!function_exists('get_array_ids')) {
    /**
     * @param array $data
     * @param string $key
     * @return array
     */
    function get_array_ids(array $data, string $key = 'id'): array
    {
        $ids = [];
        foreach ($data as $item) {
            $id = $item[$key] ?? false;
            if ($id === false) {
                continue;
            }
            $ids[$id] = 0;
        }
        return array_keys($ids);
    }
}

if (!function_exists('get_platform')) {
    /**
     * @return array|string|null
     */
    function get_platform()
    {
        // 如果默认读取不到，则将平台统一设置为 ‘APP’
        $platform = strtoupper(request()->header('meedu-platform', \App\Constant\FrontendConstant::LOGIN_PLATFORM_APP));
        $platforms = [
            \App\Constant\FrontendConstant::LOGIN_PLATFORM_APP,
            \App\Constant\FrontendConstant::LOGIN_PLATFORM_PC,
            \App\Constant\FrontendConstant::LOGIN_PLATFORM_H5,
            \App\Constant\FrontendConstant::LOGIN_PLATFORM_IOS,
            \App\Constant\FrontendConstant::LOGIN_PLATFORM_ANDROID,
            \App\Constant\FrontendConstant::LOGIN_PLATFORM_MINI,
            \App\Constant\FrontendConstant::LOGIN_PLATFORM_OTHER,
        ];
        if (!in_array($platform, $platforms)) {
            $platform = \App\Constant\FrontendConstant::LOGIN_PLATFORM_APP;
        }
        return $platform;
    }
}

if (!function_exists('get_cache_key')) {
    /**
     * @param $key
     * @param mixed ...$params
     * @return string
     */
    function get_cache_key(string $key, ...$params): string
    {
        return sprintf($key, ...$params);
    }
}

if (!function_exists('query_builder')) {
    /**
     * @param array $fields
     * @param array $rewrite
     * @return string
     */
    function query_builder(array $fields, array $rewrite = []): string
    {
        $request = request();
        $data = [
            'page' => $request->input('page', 1),
        ];
        foreach ($fields as $item) {
            $data[$item] = $request->input($item, '');
        }
        $rewrite && $data = array_merge($data, $rewrite);
        return http_build_query($data);
    }
}

if (!function_exists('save_image')) {
    function save_image($file): array
    {
        /**
         * @var \Illuminate\Http\UploadedFile $file
         */

        /**
         * @var $configService \App\Services\Base\Services\ConfigService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
        $disk = $configService->getImageStorageDisk();
        $path = $file->store($configService->getImageStoragePath(), compact('disk'));
        $url = url(\Illuminate\Support\Facades\Storage::disk($disk)->url($path));
        $data = compact('path', 'url', 'disk');
        $data['encryptData'] = encrypt(json_encode($data));
        return $data;
    }
}
