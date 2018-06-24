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
        if (! $isActive) {
            $currentRouteNameArray = explode('.', $currentRouteName);
            unset($currentRouteNameArray[count($currentRouteNameArray) - 1]);
            $currentRouteName = implode('.', $currentRouteNameArray);
            $isActive = preg_match("/{$currentRouteName}/", $routeName) ? 'active' : '';
        }
        return $isActive;
    }
}