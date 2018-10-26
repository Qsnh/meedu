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

use App\Models\Order;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CourseRepository;
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
        $comment = $course->commentHandler($request->input('content'));
        $comment ? flash('评论成功', 'success') : flash('评论失败');

        return back();
    }

    public function showBuyPage($id)
    {
        $course = Course::findOrFail($id);
        $title = sprintf('购买课程《%s》', $course->title);

        return view('frontend.course.buy', compact('course', 'title'));
    }

    public function buyHandler(CourseRepository $repository, $id)
    {
        $course = Course::findOrFail($id);
        $user = Auth::user();

        $order = $repository->createOrder($user, $course);
        if (! ($order instanceof Order)) {
            flash($order, 'warning');

            return back();
        }

        flash('下单成功，请尽快支付', 'success');

        return redirect(route('order.show', $order->order_id));
    }
}
