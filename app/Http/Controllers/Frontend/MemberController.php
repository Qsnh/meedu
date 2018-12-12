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

        return v('frontend.member.index', compact('announcement', 'videos', 'title'));
    }

    public function showPasswordResetPage()
    {
        $title = '修改密码';

        return v('frontend.member.password_reset', compact('title'));
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

        return v('frontend.member.avatar', compact('title'));
    }

    /**
     * 头像更换.
     *
     * @param AvatarChangeRequest $request
     * @param MemberRepository    $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function avatarChangeHandler(AvatarChangeRequest $request, MemberRepository $repository)
    {
        [$path, $url] = $request->filldata();
        $repository->avatarChangeHandler(Auth::user(), $url);
        flash('头像更换成功', 'success');

        return back();
    }

    /**
     * 会员订阅界面.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showJoinRoleRecordsPage(MemberRepository $repository)
    {
        $records = $repository->roleBuyRecords();
        $title = 'VIP会员记录';

        return v('frontend.member.join_role_records', compact('records', 'title'));
    }

    /**
     * 我的消息页面.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMessagesPage(MemberRepository $repository)
    {
        $messages = $repository->messages();
        $title = '我的消息';

        return v('frontend.member.messages', compact('messages', 'title'));
    }

    /**
     * 已购买课程页面.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBuyCoursePage(MemberRepository $repository)
    {
        $courses = $repository->buyCourses();
        $title = '我的购买的课程';

        return v('frontend.member.buy_course', compact('courses', 'title'));
    }

    /**
     * 已购买视频界面.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBuyVideoPage(MemberRepository $repository)
    {
        $videos = $repository->buyVideos();
        $title = '我购买的视频';

        return v('frontend.member.buy_video', compact('videos', 'title'));
    }

    /**
     * 充值记录界面.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRechargeRecordsPage(MemberRepository $repository)
    {
        $records = $repository->rechargeRecords();
        $title = '我的充值记录';

        return v('frontend.member.show_recharge_records', compact('records', 'title'));
    }

    /**
     * 我的订单界面.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrdersPage(MemberRepository $repository)
    {
        $orders = $repository->orders();
        $title = '我的订单';

        return v('frontend.member.show_orders', compact('orders', 'title'));
    }

    /**
     * 显示我的电子书界面.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBooksPage(MemberRepository $repository)
    {
        $books = $repository->buyBooks();

        return v('frontend.member.show_books', compact('books'));
    }

    /**
     * 显示第三方登录界面.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSocialitePage()
    {
        $apps = Auth::user()->socialite()->get();

        return v('frontend.member.socialite', compact('apps'));
    }
}
