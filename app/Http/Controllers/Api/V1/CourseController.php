<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiV1Exception;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;
use App\Http\Resources\CourseCommentResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\VideoRecourse;
use App\Models\Course;
use App\Models\CourseComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $courses = Course::show()
            ->published()
            ->orderByDesc('created_at')
            ->paginate($request->input('page_size', 10));
        return CourseResource::collection($courses);
    }

    public function show($id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        return new CourseResource($course);
    }

    public function videos($id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        $videos = $course->getAllPublishedAndShowVideosCache();
        return VideoRecourse::collection($videos);
    }

    public function comments(Request $request, $id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        $comments = $course->comments()
            ->orderByDesc('created_at')
            ->paginate($request->input('page_size', 10));
        return CourseCommentResource::collection($comments);
    }

    public function commentHandler(CourseOrVideoCommentCreateRequest $request, $id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        $comment = $course->commentHandler($request->input('content'));
        throw_if(! $comment, new ApiV1Exception('系统错误'));
        return new CourseCommentResource($comment);
    }

}
