<?php

if (! function_exists('flash')) {
    function flash($message, $level = 'warning')
    {
        $message = new \Illuminate\Support\MessageBag([$level => $message]);
        request()->session()->flash($level, $message);
    }
}

if (! function_exists('get_first_flash')) {
    /**
     * 获取第一条FLASH信息
     * @param $level
     * @return mixed|string
     */
    function get_first_flash($level)
    {
        if (! session()->has($level)) {
            return '';
        }
        return session($level)->first();
    }
}

if (! function_exists('menu_is_active')) {
    /**
     * 指定路由名是否与当前访问的路由名相同
     * @param $routeName
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
    function exception_response(Exception $exception, string $message = '')
    {
        return [
            'message' => $message ?: $exception->getMessage(),
            'code' => $exception->getCode() ?: 500,
        ];
    }
}

if (! function_exists('notification_name')) {
    function notification_name($notificationName)
    {
        $arr = explode('\\', $notificationName);
        $name = $arr[count($arr) - 1];
        return strtolower($name);
    }
}

if (! function_exists('at_user')) {
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

if (! function_exists('at_notification_parse')) {
    function at_notification_parse($notification)
    {
        $data = $notification->data;
        $fromUser = \App\User::find($data['from_user_id']);
        $model = '\\App\\Models\\' . $data['from_type'];
        $from = (new $model)->whereId($data['from_id'])->first();
        $url = 'javascript:void(0)';
        switch ($data['from_type']) {
            case 'CourseComment':
                $url = route('course.show', [$from->course->id, $from->course->slug]);
                break;
            case 'VideoComment':
                $url = route('video.show', [$from->video->course->id, $from->video->id, $from->video->slug]);
                break;
        }
        return '<a href="' . $url . '">用户&nbsp;<b>' . $fromUser->nick_name . '</b>&nbsp;提到您啦。</a>';
    }
}