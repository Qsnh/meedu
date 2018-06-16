<?php

return [

    // 会员配置
    'member' => [
        'is_active_default' => \App\User::ACTIVE_NO,
        'is_lock_default' => \App\User::LOCK_NO,
    ],

    // 管理员配置
    'administrator' => [
        'super_slug' => 'administrator',
    ],

];