<?php

/*
 * This file is part of the MeEdu.
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
         * @var \App\Services\Base\Interfaces\ConfigServiceInterface $configService
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
         * @var \App\Services\Base\Services\CacheService $cacheService
         */
        $cacheService = app()->make(\App\Services\Base\Interfaces\CacheServiceInterface::class);
        $cacheKey = '';
        if (isset($video['id']) && $video['id']) {
            $cacheKey = get_cache_key(
                \App\Constant\CacheConstant::ALIYUN_PLAY_URL['name'],
                $video['id'],
                $isTry ? 1 : 0,
                $video['aliyun_video_id']
            );
            $playUrl = $cacheService->get($cacheKey);
            if ($playUrl) {
                return unserialize($playUrl);
            }
        }


        /**
         * @var \App\Services\Base\Interfaces\ConfigServiceInterface $configService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
        $config = $configService->getAliyunVodConfig();

        $videoFormatWhitelist = $configService->getPlayVideoFormatWhitelist();

        try {
            aliyun_sdk_client();

            $playConfig = [];
            ($isTry && $video['free_seconds'] > 0) && $playConfig['PreviewTime'] = $video['free_seconds'];

            $query = ['VideoId' => $video['aliyun_video_id']];

            // 播放参数配置[试看]
            $playConfig && $query['PlayConfig'] = json_encode($playConfig);
            // 视频播放格式白名单
            $videoFormatWhitelist && $query['Formats'] = implode(',', $videoFormatWhitelist);

            $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
                ->product('Vod')
                ->host($config['host'])
                ->version('2017-03-21')
                ->action('GetPlayInfo')
                ->options(['query' => $query])
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

            if ($cacheKey && $rows) {
                // 写入缓存
                $cacheService->put($cacheKey, serialize($rows), \App\Constant\CacheConstant::ALIYUN_PLAY_URL['expire']);
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
         * @var \App\Services\Base\Interfaces\ConfigServiceInterface $configService
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

if (!function_exists('get_payments')) {
    /**
     * @param $scene
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function get_payments($scene)
    {
        /**
         * @var \App\Services\Base\Interfaces\ConfigServiceInterface $configService
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
        /**
         * @var \App\Services\Base\Interfaces\ConfigServiceInterface $configService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);
        $config = $configService->getTencentVodConfig();

        try {
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
                $supportFormat = $configService->getPlayVideoFormatWhitelist();
                foreach ($response->MediaInfoSet[0]->TranscodeInfo->TranscodeSet as $item) {
                    $url = $item->Url;
                    $format = strtolower(pathinfo($url, PATHINFO_EXTENSION));
                    if ($supportFormat && !in_array($format, $supportFormat)) {
                        // 视频播放格式白名单校验
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
            // 开启播放key
            $tencentKey = app()->make(\App\Meedu\Player\TencentKey::class);
            $playUrl = array_map(function ($item) use ($tencentKey, $isTry, $video) {
                $item['url'] = $tencentKey->url($item['url'], $isTry, $video);
                return $item;
            }, $playUrl);
        } else {
            $playUrl[] = [
                'url' => $video['url'],
                'format' => pathinfo($video['url'], PATHINFO_EXTENSION),
                'name' => '',
                'duration' => 0,
            ];
        }

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

if (!function_exists('save_image')) {
    function save_image($file, $group = ''): array
    {
        /**
         * @var \Illuminate\Http\UploadedFile $file
         */

        /**
         * @var \App\Services\Base\Interfaces\ConfigServiceInterface $configService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);

        /**
         * @var \App\Meedu\ServiceV2\Services\OtherServiceInterface $otherService
         */
        $otherService = app()->make(\App\Meedu\ServiceV2\Services\OtherServiceInterface::class);

        // 获取图片存储磁盘[public:本地,oss:阿里云,cos:腾讯云]
        $disk = $configService->getImageStorageDisk();
        // 保存图片并返回存储的的路径
        $path = $file->store($configService->getImageStoragePath() . ($group ? '/' . $group : ''), compact('disk'));
        // 根据path获取对应磁盘的访问url
        $url = url(\Illuminate\Support\Facades\Storage::disk($disk)->url($path));

        $name = mb_substr(strip_tags($file->getClientOriginalName()), 0, 254);
        $data = compact('path', 'url', 'disk', 'name');
        $data['expired_time'] = time() + 1800;
        $data['encryptData'] = encrypt(json_encode($data));

        $userId = 0;
        if (\Illuminate\Support\Facades\Auth::guard(\App\Constant\FrontendConstant::API_GUARD)->check()) {
            $userId = \Illuminate\Support\Facades\Auth::guard(\App\Constant\FrontendConstant::API_GUARD)->id();
        }

        $otherService->storeUserUploadImage(
            $userId,
            $group,
            $disk,
            $path,
            $name,
            $url,
            request()->path(),
            request()->getClientIp(),
            request_ua()
        );

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
        return true;
    }
}

if (!function_exists('mobile_code_check')) {
    function mobile_code_check($mobile, $mobileCode)
    {
        if (!$mobile || !$mobileCode) {
            return false;
        }

        // 测试环境固定验证码
        if (is_dev() && $mobileCode === '112233') {
            return true;
        }

        /**
         * @var $cacheService \App\Services\Base\Services\CacheService
         */
        $cacheService = app()->make(\App\Services\Base\Interfaces\CacheServiceInterface::class);

        $mobileCodeKey = get_cache_key(\App\Constant\CacheConstant::MOBILE_CODE['name'], $mobile);
        $mobileCodeSafeKey = get_cache_key(\App\Constant\CacheConstant::MOBILE_CODE_SAFE['name'], $mobile);

        // 校验次数写入缓存
        // 在[校验成功]或者[触发安全机制]之后会被删除
        if ($cacheService->has($mobileCodeSafeKey)) {
            $cacheService->inc($mobileCodeSafeKey, 1);
        } else {
            // 第一次写入，未防止并发校验写入结果
            // 如果因为并发导致的非第一次写入的话，那么本次写入失败
            // 验证码校验无法继续
            if (!$cacheService->add($mobileCodeSafeKey, 1, \App\Constant\CacheConstant::MOBILE_CODE_SAFE['expire'])) {
                return false;
            }
        }

        $code = $cacheService->get($mobileCodeKey);
        if ($code && $code === $mobileCode) {
            $cacheService->forget($mobileCodeKey);
            $cacheService->forget($mobileCodeSafeKey);
            return true;
        }

        $verifyCount = (int)$cacheService->get($mobileCodeSafeKey);
        if ($verifyCount > 10) {
            // 如果短信验证码校验超过10次都是失败的话，那么直接忘掉该手机的短信验证码
            // 间接要求用户重新发送短信验证码
            $cacheService->forget($mobileCodeKey);
            $cacheService->forget($mobileCodeSafeKey);
        }

        return false;
    }
}

if (!function_exists('token_payload')) {
    /**
     * TokenPayload解析
     *
     * @param string $token
     * @return array
     * @throws \App\Exceptions\ServiceException
     */
    function token_payload(string $token): array
    {
        $arr = explode('.', $token);
        if (count($arr) !== 3) {
            throw new \App\Exceptions\ServiceException(__('token格式错误'));
        }
        return json_decode(base64_decode($arr[1]), true);
    }
}

if (!function_exists('request_ua')) {
    function request_ua($maxLength = 255): string
    {
        $ua = request()->header('User-Agent', '');
        mb_strlen($ua) > $maxLength && $ua = mb_substr($ua, 0, $maxLength);
        return $ua;
    }
}

if (!function_exists('base64_save')) {
    function base64_save(string $base64Content, string $path, string $namePrefix, string $extension)
    {
        /**
         * @var \App\Services\Base\Interfaces\ConfigServiceInterface $configService
         */
        $configService = app()->make(\App\Services\Base\Interfaces\ConfigServiceInterface::class);

        $name = ($namePrefix ? $namePrefix . '-' : '') . \Illuminate\Support\Str::random(32) . '.' . $extension;
        $path .= DIRECTORY_SEPARATOR . $name;

        // 获取存储磁盘[public:本地,oss:阿里云,cos:腾讯云]
        $disk = $configService->getImageStorageDisk();
        // 保存图片并返回存储的的路径
        $uploadResult = \Illuminate\Support\Facades\Storage::disk($disk)->put($path, base64_decode($base64Content));
        // 根据path获取对应磁盘的访问url
        $url = url(\Illuminate\Support\Facades\Storage::disk($disk)->url($path));

        return compact('path', 'url', 'disk', 'name');
    }
}

if (!function_exists('id_mask')) {
    function id_mask(string $idNumber): string
    {
        if (!$idNumber) {
            return '';
        }
        if (mb_strlen($idNumber) === 15) {
            return mb_substr($idNumber, 0, 6) . '****' . mb_substr($idNumber, 12, 3);
        }
        return mb_substr($idNumber, 0, 6) . '****' . mb_substr($idNumber, 14, 4);
    }
}

if (!function_exists('name_mask')) {
    function name_mask(string $name): string
    {
        if (!$name) {
            return '';
        }
        $length = mb_strlen($name);
        if ($length === 1) {
            return $name;
        } elseif ($length === 2) {
            return mb_substr($name, 0, 1) . '*';
        }
        return mb_substr($name, 0, 1) . '*' . mb_substr($name, -1, 1);
    }
}
