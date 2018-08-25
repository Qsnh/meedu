<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\CourseComment;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::show()->published()->orderByDesc('created_at')->get();
        return view('frontend.course.index', compact('courses'));
    }

    public function show($id, $slug)
    {
        $course = Course::with(['comments', 'user', 'comments.user'])
            ->show()
            ->published()
            ->whereId($id)
            ->firstOrFail();
        return view('frontend.course.show', compact('course'));
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

}
