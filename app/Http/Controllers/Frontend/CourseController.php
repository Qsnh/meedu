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

class CourseController extends FrontendController
{
    public function index()
    {
        $courses = Course::show()
            ->published()
            ->orderByDesc('created_at')
            ->paginate(6);
        ['title' => $title, 'keywords' => $keywords, 'description' => $description] = config('meedu.seo.course_list');

        return v('frontend.course.index', compact('courses', 'title', 'keywords', 'description'));
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
        $comments = $course->comments()->orderByDesc('created_at')->limit(8)->get();

        return v('frontend.course.show', compact(
            'course',
            'title',
            'keywords',
            'description',
            'comments'
        ));
    }

    public function showBuyPage($id)
    {
        $course = Course::findOrFail($id);
        $title = sprintf('购买课程《%s》', $course->title);

        return v('frontend.course.buy', compact('course', 'title'));
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
