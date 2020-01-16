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
        if ($level == 'error' && session('errors') && session('errors')->any()) {
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
        return request()->route()->getName() == $routeName ? 'active' : '';
    }
}

if (!function_exists('exception_response')) {
    /**
     * 异常响应.
     *
     * @param Exception $exception
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function exception_response(Exception $exception, string $message = '')
    {
        return response()->json([
            'message' => $message ?: $exception->getMessage(),
            'code' => $exception->getCode() ?: 500,
        ]);
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
            'file' => $exception->getFile(),
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
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

if (!function_exists('admin')) {
    /**
     * 获取当前登录的管理员.
     *
     * @return \App\Models\Administrator
     */
    function admin()
    {
        return \Illuminate\Support\Facades\Auth::guard('administrator')->user();
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

if (!function_exists('markdown_clean')) {
    /**
     * 过滤markdown非法字符串.
     *
     * @param string $markdownContent
     *
     * @return string
     */
    function markdown_clean(string $markdownContent)
    {
        $html = markdown_to_html($markdownContent);
        $safeHtml = clean($html, null);

        return (new \League\HTMLToMarkdown\HtmlConverter())->convert($safeHtml);
    }
}

if (!function_exists('image_url')) {
    /**
     * 给图片添加参数.
     *
     * @param $url
     *
     * @return string
     */
    function image_url($url)
    {
        $params = config('meedu.upload.image.params', '');

        return strstr('?', $url) !== false ? $url . $params : $url . '?' . $params;
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
     *
     * @param \App\Models\Video $video
     *
     * @return array
     */
    function aliyun_play_url(\App\Models\Video $video)
    {
        if (!$video->aliyun_video_id) {
            return [];
        }
        try {
            $client = aliyun_sdk_client();
            $request = new \vod\Request\V20170321\GetPlayInfoRequest();
            $request->setVideoId($video->aliyun_video_id);
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
        $client = new \DefaultAcsClient($profile);

        return $client;
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

        return view($viewName, $params);
    }
}

if (!function_exists('is_h5')) {
    /**
     * @return bool
     */
    function is_h5()
    {
        return session()->has(\App\Constant\FrontendConstant::H5);
    }
}

if (!function_exists('is_wechat')) {
    /**
     * @return bool
     */
    function is_wechat()
    {
        if (strpos(request()->header('HTTP_USER_AGENT'), 'MicroMessenger') !== false) {
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
        if ($duration instanceof \App\Models\Video) {
            $duration = $duration->duration;
        }
        $minute = intdiv($duration, 60);
        $second = $duration % 60;
        if ($minute > 60) {
            $hours = intdiv($minute, 60);
            $minute = $minute % 60;

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
            return $item['enabled'] == 1;
        });

        return $enabled;
    }
}

if (!function_exists('get_payments')) {
    /**
     * 获取可用的Payment.
     *
     * @return \Illuminate\Support\Collection
     */
    function get_payments($scene)
    {
        /**
         * @var \App\Services\Base\Services\ConfigService
         */
        $configService = app()->make(\App\Services\Base\Services\ConfigService::class);
        $payments = collect($configService->getPayments())->filter(function ($payment) use ($scene) {
            $enabled = $payment['enabled'] ?? false;
            $isSet = $payment[$scene] ?? false;

            return $enabled && $isSet;
        });

        return $payments;
    }
}

if (!function_exists('app_menu_is_active')) {
    function app_menu_is_active($menu)
    {
        $request = request();
        $const = [
            'index' => [
                'index',
            ],
            'courses' => [
                'courses',
                'videos',
                'course.show',
                'video.show',
                'search',
                'member.course.buy',
                'member.video.buy',
            ],
            'role' => [
                'role.index',
                'member.role.buy',
            ],
        ];
        $menus = $const[$menu] ?? [];
        if (!$menus) {
            return false;
        }
        if ($request->routeIs(...$menus)) {
            return true;
        }

        return false;
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
        if (count($result[1] ?? []) == 0) {
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
     */
    function random_number($prefix, $length): string
    {
        $prefixLength = mb_strlen($prefix);
        $length -= $prefixLength;
        for ($i = 0; $i < $length; $i++) {
            $prefix .= mt_rand(0, 9);
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
     * @return array
     */
    function arr2_clear($arr, $columns)
    {
        return array_map(function ($item) use ($columns) {
            return \Illuminate\Support\Arr::only($item, $columns);
        }, $arr);
    }
}
