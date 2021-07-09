<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

class BackendApiConstant
{
    public const GUARD = 'administrator';

    public const ERROR_CODE = 500;
    public const NO_AUTH_CODE = 401;

    public const PERMISSION_WHITE_LIST = [
        'user' => true,
        'menus' => true,
        'login' => true,
        'dashboard' => true,
        'dashboard/system/info' => true,
        'dashboard/check' => true,
        'role/all' => true,
        'administrator_permission' => true,
        'course/all' => true,
        'upload/image/tinymce' => true,
        'upload/image/download' => true,
    ];
}
