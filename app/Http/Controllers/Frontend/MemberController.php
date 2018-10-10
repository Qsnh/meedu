<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Announcement;
use App\Models\UserJoinRoleRecord;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MemberRepository;
use App\Http\Requests\Frontend\Member\AvatarChangeRequest;
use App\Http\Requests\Frontend\Member\MemberPasswordResetRequest;

class MemberController extends FrontendController
{
    public function index()
    {
        $announcement = Announcement::recentAnnouncement();
        $videos = Auth::user()->buyVideos()->orderByDesc('pivot_created_at')->limit(10)->get();
        $title = '会员中心';

        return view('frontend.member.index', compact('announcement', 'videos', 'title'));
    }

    public function showPasswordResetPage()
    {
        $title = '修改密码';

        return view('frontend.member.password_reset', compact('title'));
    }

    /**
     * 密码修改.
     *
     * @param MemberPasswordResetRequest $request
     * @param MemberRepository           $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordResetHandler(MemberPasswordResetRequest $request, MemberRepository $repository)
    {
        [$oldPassword, $newPassword] = $request->filldata();
        if (! $repository->passwordChangeHandler($oldPassword, $newPassword)) {
            flash($repository->errors);
        } else {
            flash('密码修改成功', 'success');
        }

        return back();
    }

    public function showAvatarChangePage()
    {
        $title = '更换头像';

        return view('frontend.member.avatar', compact('title'));
    }

    public function avatarChangeHandler(AvatarChangeRequest $request)
    {
        [$path, $url] = $request->filldata();
        $user = Auth::user();
        $user->avatar = $url;
        $user->save();
        flash('头像更换成功', 'success');

        return back();
    }

    public function showJoinRoleRecordsPage()
    {
        $records = UserJoinRoleRecord::whereUserId(Auth::id())->orderByDesc('expired_at')->paginate(8);
        $title = 'VIP会员记录';

        return view('frontend.member.join_role_records', compact('records', 'title'));
    }

    public function showMessagesPage()
    {
        $messages = new Paginator(Auth::user()->notifications, 10);
        $messages->setPath(route('member.messages'));
        $title = '我的消息';

        return view('frontend.member.messages', compact('messages', 'title'));
    }

    public function showBuyCoursePage()
    {
        $courses = Auth::user()->joinCourses()->orderByDesc('pivot_created_at')->paginate(16);
        $title = '我的购买的课程';

        return view('frontend.member.buy_course', compact('courses', 'title'));
    }

    public function showBuyVideoPage()
    {
        $videos = Auth::user()->buyVideos()->orderByDesc('pivot_created_at')->paginate(16);
        $title = '我购买的视频';

        return view('frontend.member.buy_video', compact('videos', 'title'));
    }

    public function showRechargeRecordsPage()
    {
        $records = Auth::user()->rechargePayments()->success()->orderByDesc('created_at')->paginate(10);
        $title = '我的充值记录';

        return view('frontend.member.show_recharge_records', compact('records', 'title'));
    }

    public function showOrdersPage()
    {
        $orders = Auth::user()->orders()->orderByDesc('created_at')->paginate(10);
        $title = '我的订单';

        return view('frontend.member.show_orders', compact('orders', 'title'));
    }
}
