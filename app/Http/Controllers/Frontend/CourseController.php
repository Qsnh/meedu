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

use Exception;
use App\Models\Order;
use App\Models\Course;
use App\Models\CourseComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SimpleMessageNotification;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;

class CourseController extends FrontendController
{
    public function index()
    {
        $courses = Course::show()
            ->published()
            ->orderByDesc('created_at')
            ->paginate(6);
        ['title' => $title, 'keywords' => $keywords, 'description' => $description] = config('meedu.seo.course_list');

        return view('frontend.course.index', compact('courses', 'title', 'keywords', 'description'));
    }

    public function show($id, $slug)
    {
        $course = Course::with(['comments', 'user', 'comments.user'])
            ->show()
            ->published()
            ->whereId($id)
            ->firstOrFail();
        $title = sprintf('课程《%s》', $course->title);
        $keywords = $course->keywords;
        $description = $course->description;

        return view('frontend.course.show', compact(
            'course',
            'title',
            'keywords',
            'description'
        ));
    }

    public function commentHandler(CourseOrVideoCommentCreateRequest $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $comment = $course->comments()->save(new CourseComment([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]));
        $comment ? flash('评论成功', 'success') : flash('评论失败');

        return back();
    }

    public function showBuyPage($id)
    {
        $course = Course::findOrFail($id);
        $title = sprintf('购买课程《%s》', $course->title);

        return view('frontend.course.buy', compact('course', 'title'));
    }

    public function buyHandler($id)
    {
        $course = Course::findOrFail($id);
        $user = Auth::user();

        if ($user->joinCourses()->whereId($course->id)->first()) {
            flash('该视频已购买啦', 'success');

            return redirect(route($course->seeUrl()));
        }

        if ($user->credit1 < $course->charge) {
            flash('余额不足请先充值');

            return redirect(route('member.recharge'));
        }

        DB::beginTransaction();
        try {
            // 创建订单记录
            $order = $user->orders()->save(new Order([
                'goods_id' => $course->id,
                'goods_type' => Order::GOODS_TYPE_COURSE,
                'charge' => $course->charge,
                'status' => Order::STATUS_PAID,
            ]));
            // 购买视频
            $user->joinACourse($course);
            // 扣除余额
            $user->credit1Dec($course->charge);
            // 消息通知
            $user->notify(new SimpleMessageNotification($order->getNotificationContent()));

            DB::commit();

            flash('购买成功', 'success');

            return redirect(route('course.show', [$course->id, $course->slug]));
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('购买失败');

            return back();
        }
    }
}
