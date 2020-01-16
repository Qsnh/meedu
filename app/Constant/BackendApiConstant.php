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
    const GUARD = 'administrator';

    const OLD_PASSWORD_ERROR = '原密码错误';
    const ADMINISTRATOR_ACCOUNT_CANT_DELETE = '当前用户是超级管理员账户无法删除';
    const PERMISSION_BAN_DELETE_FOR_CHILDREN = '该权限下还有角色，请先删除该角色';
    const ROLE_BAN_DELETE_FOR_ADMINISTRATOR = '该角色下还存在管理员，请先删除相应的管理员';
    const ROLE_BAN_DELETE_FOR_INIT_ADMINISTRATOR = '超管角色无法删除';
    const COURSE_CHAPTER_BAN_DELETE_FOR_VIDEOS = '无法删除，该章节下面存在视频';
    const COURSE_BAN_DELETE_FOR_VIDEOS = '该课程下存在视频，无法删除';

    const LOGIN_USERNAME_REQUIRED = '请输入用户名';
    const LOGIN_PASSWORD_REQUIRED = '请输入密码';
    const LOGIN_PASSWORD_ERROR = '密码错误';

    const ADMINISTRATOR_NOT_EXISTS = '用户名不存在';

    const ERROR_CODE = 500;
    const NO_AUTH_CODE = 401;

    const LOCAL_PUBLIC_DISK = 'public';
}
