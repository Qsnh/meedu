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