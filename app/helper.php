<?php
if (! function_exists('flash')) {
    function flash($message, $level = 'warning')
    {
        request()->session()->flash($level, $message);
    }
}