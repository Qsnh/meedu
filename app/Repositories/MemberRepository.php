<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories;

use App\Models\UserJoinRoleRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberRepository
{
    public $errors = '';

    /**
     * 会员密码修改逻辑.
     *
     * @param $oldPassword
     * @param $newPassword
     *
     * @return bool
     */
    public function passwordChangeHandler($oldPassword, $newPassword): bool
    {
        $user = Auth::user();
        if (! Hash::check($oldPassword, $user->password)) {
            $this->errors = '原密码不正确';

            return false;
        }
        $user->password = bcrypt($newPassword);
        $user->save();

        return true;
    }

    /**
     * 会员的充值记录.
     *
     * @return mixed
     */
    public function rechargeRecords()
    {
        $records = Auth::user()
            ->rechargePayments()
            ->success()
            ->orderByDesc('created_at')
            ->paginate(request()->input('page_size', 10));

        return $records;
    }

    /**
     * 已购买的课程.
     *
     * @return mixed
     */
    public function buyCourses()
    {
        $courses = Auth::user()
            ->joinCourses()
            ->orderByDesc('pivot_created_at')
            ->paginate(request()->input('page_size', 10));

        return $courses;
    }

    /**
     * 已购买视频.
     *
     * @return mixed
     */
    public function buyVideos()
    {
        $videos = Auth::user()
            ->buyVideos()
            ->orderByDesc('pivot_created_at')
            ->paginate(request()->input('page_size', 10));

        return $videos;
    }

    /**
     * 订单.
     *
     * @return mixed
     */
    public function orders()
    {
        $orders = Auth::user()
            ->orders()
            ->orderByDesc('created_at')
            ->paginate(request()->input('page_size', 10));

        return $orders;
    }

    /**
     * 会员订阅记录.
     *
     * @return mixed
     */
    public function roleBuyRecords()
    {
        $records = UserJoinRoleRecord::whereUserId(Auth::id())
            ->orderByDesc('expired_at')
            ->paginate(request()->input('page_size', 10));

        return $records;
    }

    /**
     * @return mixed
     */
    public function messages()
    {
        $messages = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(request()->input('page_size', 10));

        return $messages;
    }

    /**
     * @param $user
     * @param $avatar
     */
    public function avatarChangeHandler($user, $avatar)
    {
        $user->avatar = $avatar;
        $user->save();
    }

    /**
     * 购买的电子书.
     *
     * @return mixed
     */
    public function buyBooks()
    {
        $books = Auth::user()->books()->orderByDesc('created_at')->paginate(10);

        return $books;
    }
}
