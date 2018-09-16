<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;
use App\Models\Course;
use App\Models\CourseComment;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends FrontendController
{

    public function index()
    {
        $courses = Course::show()
            ->published()
            ->orderByDesc('created_at')
            ->paginate(6);
        return view('frontend.course.index', compact('courses'));
    }

    public function show($id, $slug)
    {
        $course = Course::with(['comments', 'user', 'comments.user'])
            ->show()
            ->published()
            ->whereId($id)
            ->firstOrFail();
        $newJoinMembers = $course->getNewJoinMembersCache();
        return view('frontend.course.show', compact('course', 'newJoinMembers'));
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
        return view('frontend.course.buy', compact('course'));
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
            $user->orders()->save(new Order([
                'goods_id' => $course->id,
                'goods_type' => Order::GOODS_TYPE_COURSE,
                'charge' => $course->charge,
                'status' => Order::STATUS_PAID,
            ]));
            // 购买视频
            $user->joinACourse($course);
            // 扣除余额
            $user->credit1Dec($course->charge);

            DB::commit();

            flash('购买成功', 'success');
            return redirect($course->seeUrl());
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('购买失败');
            return back();
        }
    }

}
