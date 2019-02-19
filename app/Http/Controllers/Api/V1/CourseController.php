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
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseListResource;
use App\Http\Resources\CourseCommentResource;
use App\Http\Resources\CourseVideoListResource;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;

class CourseController extends Controller
{
    /**
     * 课程列表.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');

        $courses = Course::show()
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('title', 'like', "%{$keywords}%");
            })
            ->published()
            ->orderByDesc('created_at')
            ->paginate($request->input('page_size', 10));

        return CourseListResource::collection($courses);
    }

    /**
     * 课程详情.
     *
     * @param $id
     *
     * @return CourseResource
     */
    public function show($id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();

        return new CourseResource($course);
    }

    /**
     * 课程下的视频.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function videos($id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        $videos = $course->getAllPublishedAndShowVideosCache();

        return CourseVideoListResource::collection($videos);
    }

    /**
     * 课程下的评论.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function comments(Request $request, $id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        $comments = $course->comments()
            ->orderByDesc('created_at')
            ->paginate($request->input('page_size', 10));

        return CourseCommentResource::collection($comments);
    }

    /**
     * 评论处理.
     *
     * @param CourseOrVideoCommentCreateRequest $request
     * @param $id
     *
     * @return CourseCommentResource
     *
     * @throws \Throwable
     */
    public function commentHandler(CourseOrVideoCommentCreateRequest $request, $id)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        $comment = $course->commentHandler($request->input('content'));
        throw_if(! $comment, new ApiV1Exception('系统错误'));

        return new CourseCommentResource($comment);
    }
}
