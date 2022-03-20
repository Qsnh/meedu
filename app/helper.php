<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

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

        /**
         * @var \App\Services\Base\Services\ConfigService $configService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);

        try {
            aliyun_sdk_client();

            $query = ['VideoId' => $video['aliyun_video_id']];
            $playConfig && $query['PlayConfig'] = json_encode($playConfig);

            $config = $configService->getAliyunVodConfig();

            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->product('Vod')
                ->host($config['host'])
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
        /**
         * @var \App\Services\Base\Services\ConfigService $configService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
        $config = $configService->getAliyunVodConfig();

        try {
            aliyun_sdk_client();

            $playConfig = [];
            ($isTry && $video['free_seconds'] > 0) && $playConfig['PreviewTime'] = $video['free_seconds'];

            $query = ['VideoId' => $video['aliyun_video_id']];
            $playConfig && $query['PlayConfig'] = json_encode($playConfig);
            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->product('Vod')
                ->host($config['host'])
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
            return \App\Constant\FrontendConstant::PAYMENT_SCENE_WECHAT;
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
            $response = $client->DescribeMediaInfos($req);
            if (!$response->MediaInfoSet) {
                // 无法获取url地址
                return [];
            }
            if ($response->MediaInfoSet[0]->TranscodeInfo) {
                // 配置了转码信息
                $urls = [];
                $supportFormat = $configService->getTencentVodTranscodeFormat();
                foreach ($response->MediaInfoSet[0]->TranscodeInfo->TranscodeSet as $item) {
                    $url = $item->Url;
                    $format = strtolower(pathinfo($url, PATHINFO_EXTENSION));
                    if ($supportFormat && !in_array($format, $supportFormat)) {
                        // 限定转码格式，只能使用一种
                        continue;
                    }
                    $urls[] = [
                        'url' => $url,
                        'format' => $format,
                        'duration' => (int)$item->Duration,
                        'name' => $item->Height,
                    ];
                }
                return $urls;
            }
            /**
             * @var $mediaBasicInfo \TencentCloud\Vod\V20180717\Models\MediaBasicInfo
             */
            $mediaBasicInfo = $response->MediaInfoSet[0]->BasicInfo;
            $metaData = $response->MediaInfoSet[0]->MetaData;
            return [
                [
                    'format' => $mediaBasicInfo->Type,
                    'url' => $mediaBasicInfo->MediaUrl,
                    'duration' => (int)$metaData->Duration,
                    'name' => $metaData->Height,
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
            // 阿里云
            $playUrl = aliyun_play_url($video, $isTry);
        } elseif ($video['tencent_video_id']) {
            // 腾讯云
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
        // 如果默认读取不到，则将平台统一设置为APP
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
    function save_image($file, $pathPrefix = ''): array
    {
        /**
         * @var \Illuminate\Http\UploadedFile $file
         */

        /**
         * @var $configService \App\Services\Base\Services\ConfigService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
        $disk = $configService->getImageStorageDisk();
        $path = $file->store($configService->getImageStoragePath() . ($pathPrefix ? '/' . $pathPrefix : ''), compact('disk'));
        $url = url(\Illuminate\Support\Facades\Storage::disk($disk)->url($path));
        $name = mb_substr(strip_tags($file->getClientOriginalName()), 0, 254);
        $data = compact('path', 'url', 'disk', 'name');
        $data['encryptData'] = encrypt(json_encode($data));
        return $data;
    }
}

if (!function_exists('url_append_query')) {
    function url_append_query(string $url, array $data): string
    {
        $query = http_build_query($data);
        if (\Illuminate\Support\Str::contains($url, '?')) {
            $url .= '&' . $query;
        } else {
            $url .= '?' . $query;
        }

        return $url;
    }
}

if (!function_exists('wechat_jssdk')) {
    /**
     * @param array $apiList
     *
     * @return array
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function wechat_jssdk(array $apiList): array
    {
        $app = \App\Meedu\Wechat::getInstance();
        return $app->jssdk->buildConfig($apiList, is_dev(), false, false);
    }
}

if (!function_exists('wechat_qrcode_image')) {
    function wechat_qrcode_image(string $code): string
    {
        $result = \App\Meedu\Wechat::getInstance()->qrcode->temporary($code, 3600);
        $url = $result['url'] ?? '';
        return 'data:image/png;base64, ' . base64_encode(\QrCode::format('png')->size(300)->generate($url));
    }
}

if (!function_exists('captcha_image_check')) {
    function captcha_image_check()
    {
        $imageKey = request()->input('image_key');
        if (!$imageKey) {
            return false;
        }
        $imageCaptcha = request()->input('image_captcha', '');
        if (!app()->make(\Mews\Captcha\Captcha::class)->check_api($imageCaptcha, $imageKey)) {
            return false;
        }
    }
}
