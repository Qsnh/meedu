<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Exceptions\ApiV1Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoRecourse;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseCommentResource;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;

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
