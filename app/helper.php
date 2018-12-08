<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

if (! function_exists('flash')) {
    function flash($message, $level = 'warning')
    {
        $message = new \Illuminate\Support\MessageBag([$level => $message]);
        request()->session()->flash($level, $message);
    }
}

if (! function_exists('get_first_flash')) {
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
        if (! session()->has($level)) {
            return '';
        }

        return session($level)->first();
    }
}

if (! function_exists('menu_is_active')) {
    /**
     * 指定路由名是否与当前访问的路由名相同.
     *
     * @param $routeName
     *
     * @return bool
     */
    function menu_is_active($routeName)
    {
        $routeName = strtolower($routeName);
        $currentRouteName = strtolower(request()->route()->getName());
        $isActive = $currentRouteName === $routeName ? 'active' : '';
        if (! $isActive && str_contains('.', $currentRouteName)) {
            $currentRouteNameArray = explode('.', $currentRouteName);
            unset($currentRouteNameArray[count($currentRouteNameArray) - 1]);
            $currentRouteName = implode('.', $currentRouteNameArray);
            $isActive = preg_match("/{$currentRouteName}[^_]/", $routeName) ? 'active' : '';
        }

        return $isActive;
    }
}

if (! function_exists('exception_response')) {
    /**
     * 异常响应.
     *
     * @param Exception $exception
     * @param string    $message
     *
     * @return array
     */
    function exception_response(Exception $exception, string $message = '')
    {
        return response()->json([
            'message' => $message ?: $exception->getMessage(),
            'code' => $exception->getCode() ?: 500,
        ]);
    }
}

if (! function_exists('at_user')) {
    /**
     * 艾特某个用户.
     *
     * @param $content
     * @param $fromUser
     * @param $from
     * @param $fromType
     */
    function at_user($content, $fromUser, $from, $fromType)
    {
        preg_match_all('/\s{1}@(.*?)\s{1}/', $content, $result);
        if (! ($result = optional($result)[1])) {
            return;
        }
        foreach ($result as $item) {
            event(new \App\Events\AtUserEvent($fromUser, $item, $from, $fromType));
        }
    }
}

if (! function_exists('exception_record')) {
    /**
     * 记录异常.
     *
     * @param Exception $exception
     */
    function exception_record(Exception $exception): void
    {
        \Log::error([
            'file' => $exception->getFile(),
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}

if (! function_exists('admin')) {
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

if (! function_exists('markdown_to_html')) {
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

if (! function_exists('markdown_clean')) {
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

if (! function_exists('image_url')) {
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

        return strstr('?', $url) !== false ? $url.$params : $url.'?'.$params;
    }
}

if (! function_exists('aliyun_play_auth')) {
    /**
     * 获取阿里云视频的播放Auth.
     *
     * @param \App\Models\Video $video
     *
     * @return mixed|SimpleXMLElement
     */
    function aliyun_play_auth(\App\Models\Video $video)
    {
        try {
            $client = aliyun_sdk_client();
            $request = new \vod\Request\V20170321\GetVideoPlayAuthRequest();
            $request->setAcceptFormat('JSON');
            $request->setRegionId(config('meedu.upload.video.aliyun.region', ''));
            $request->setVideoId($video->aliyun_video_id);
            $response = $client->getAcsResponse($request);

            return $response->PlayAuth;
        } catch (Exception $exception) {
            exception_record($exception);

            return '';
        }
    }
}

if (! function_exists('aliyun_play_url')) {
    /**
     * 获取阿里云的视频播放地址
     *
     * @param \App\Models\Video $video
     *
     * @return array
     */
    function aliyun_play_url(\App\Models\Video $video)
    {
        if (! $video->aliyun_video_id) {
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

if (! function_exists('aliyun_sdk_client')) {
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

if (! function_exists('backend_menus')) {
    /**
     * 获取当前管理员的专属菜单.
     *
     * @return array|mixed
     */
    function backend_menus()
    {
        $user = admin();
        if (! $user) {
            return collect([]);
        }
        if ($user->isSuper()) {
            return (new \App\Models\AdministratorMenu())->menus();
        }
        $permissionIds = $user->permissionIds();
        $permissionIds->push(0);
        $menus = \App\Models\AdministratorMenu::with('children')
            ->whereIn('permission_id', $permissionIds)
            ->rootLevel()
            ->orderAsc()
            ->get();
        $menus = $menus->filter(function ($menu) use ($permissionIds) {
            if ($menu->children->isEmpty()) {
                return false;
            }
            $permissionIds = $permissionIds->toArray();
            $children = $menu->children->filter(function ($child) use ($permissionIds) {
                return in_array($child->permission_id, $permissionIds);
            });
            $menu->children = $children;

            return $children->count() != 0;
        });

        return $menus;
    }
}

if (! function_exists('gen_order_no')) {
    /**
     * 生成订单号.
     *
     * @param \App\User $user
     *
     * @return string
     */
    function gen_order_no(\App\User $user)
    {
        $userId = str_pad($user->id, 10, 0, STR_PAD_LEFT);
        $time = date('His');
        $rand = mt_rand(10, 99);

        return $time.$rand.$userId;
    }
}

if (! function_exists('input_equal')) {
    /**
     * GET参数是否等于指定值
     *
     * @param $field
     * @param $value
     * @param string $default
     *
     * @return bool
     */
    function input_equal($field, $value, $default = '')
    {
        return request()->input($field, $default) == $value;
    }
}

if (! function_exists('env_update')) {
    /**
     * ENV文件修改.
     *
     * @param array $data
     */
    function env_update(array $data)
    {
        $env = app()->make('files')->get(base_path('.env'));
        $envRows = explode("\n", $env);
        $updatedColumns = array_keys($data);
        $newEnvRows = [];
        foreach ($envRows as $envRow) {
            if ($envRow == '') {
                $newEnvRows[] = '';
                continue;
            }
            [$itemKey, $itemValue] = explode('=', $envRow);
            if (! in_array($itemKey, $updatedColumns)) {
                $newEnvRows[] = $envRow;
                continue;
            }
            $updatedValue = $data[$itemKey];
            $updatedValue = str_replace(' ', '', trim($updatedValue));
            if (is_numeric($updatedValue)) {
                $newEnvRows[] = $itemKey.'='.$updatedValue;
            } elseif (is_bool($updatedValue)) {
                $newEnvRows[] = $itemKey.'='.$updatedValue ? 'true' : 'false';
            } else {
                $newEnvRows[] = $itemKey.'="'.$updatedValue.'"';
            }
        }
        app()->make('files')->put(base_path('.env'), implode("\n", $newEnvRows));
    }
}
