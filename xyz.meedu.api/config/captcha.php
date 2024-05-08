<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

return [

    'characters' => '2346789abcdefghmnpqrtuxyzABCDEFGHMNPQRTUXYZ',

    'default' => [
        'length' => 4,
        'width' => 120,
        'height' => 48,
        'quality' => 90,
        // 验证码过期时间 - 5分钟
        'expire' => 300,
    ],

    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 90,
        'lines' => 6,
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'contrast' => -5,
    ],

    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],

    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]

];
