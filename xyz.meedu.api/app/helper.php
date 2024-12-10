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

if (!function_exists('is_dev')) {
    /**
     * @return bool|string
     */
    function is_dev()
    {
        return app()->environment(['dev', 'local']);
    }
}

if (!function_exists('is_testing')) {
    /**
     * @return bool|string
     */
    function is_testing()
    {
        return app()->environment(['test', 'testing']);
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
    function save_image($file, $scene = ''): array
    {
        /**
         * @var \Illuminate\Http\UploadedFile $file
         */

        /**
         * @var \App\Bus\UploadBus $uploadBus
         */
        $uploadBus = app()->make(\App\Bus\UploadBus::class);

        $user = \Illuminate\Support\Facades\Auth::guard(\App\Constant\FrontendConstant::API_GUARD)->user();

        if (!$scene) {
            $scene = 'other';
        }

        $data = $uploadBus->uploadFile2Public(
            $user['nick_name'],
            sprintf('u-%d', $user['id']),
            $file,
            $scene,
            $scene
        );

        /**
         * @var \App\Meedu\ServiceV2\Services\OtherServiceInterface $otherService
         */
        $otherService = app()->make(\App\Meedu\ServiceV2\Services\OtherServiceInterface::class);

        $otherService->storeUserUploadImage(
            $user['id'],
            $scene,
            $data['disk'],
            $data['path'],
            $data['name'],
            $data['url'],
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
        if (!isset($result['url'])) {
            \Illuminate\Support\Facades\Log::error(__METHOD__ . '|微信扫码登录生成二维码失败,返回信息:' . json_encode($result, JSON_UNESCAPED_UNICODE));
            throw new \App\Exceptions\ServiceException(__('生成微信临时二维码失败'));
        }
        return 'data:image/png;base64, ' . base64_encode(\QrCode::format('png')->size(300)->generate($result['url']));
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
