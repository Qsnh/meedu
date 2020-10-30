<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Constant;

class BackendApiConstant
{
    public const GUARD = 'administrator';

    public const OLD_PASSWORD_ERROR = '原密码错误';
    public const ADMINISTRATOR_ACCOUNT_CANT_DELETE = '当前用户是超级管理员账户无法删除';
    public const PERMISSION_BAN_DELETE_FOR_CHILDREN = '该权限下还有角色，请先删除该角色';
    public const ROLE_BAN_DELETE_FOR_ADMINISTRATOR = '该角色下还存在管理员，请先删除相应的管理员';
    public const ROLE_BAN_DELETE_FOR_INIT_ADMINISTRATOR = '超管角色无法删除';
    public const COURSE_CHAPTER_BAN_DELETE_FOR_VIDEOS = '无法删除，该章节下面存在视频';
    public const COURSE_BAN_DELETE_FOR_VIDEOS = '该课程下存在视频，无法删除';

    public const LOGIN_USERNAME_REQUIRED = '请输入用户名';
    public const LOGIN_PASSWORD_REQUIRED = '请输入密码';
    public const LOGIN_PASSWORD_ERROR = '密码错误';

    public const ADMINISTRATOR_NOT_EXISTS = '用户名不存在';

    public const ERROR_CODE = 500;
    public const NO_AUTH_CODE = 401;

    public const LOCAL_PUBLIC_DISK = 'public';

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
