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

use App\Models\Video;
use Illuminate\Http\Request;
use App\Exceptions\ApiV1Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VideoRecourse;
use App\Http\Resources\VideoCommentResource;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;

class VideoController extends Controller
{
    /**
     * 视频详情.
     *
     * @param $id
     *
     * @return VideoRecourse
     */
    public function show($id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();

        return new VideoRecourse($video);
    }

    /**
     * 视频的播放路径.
     *
     * @param $id
     *
     * @return array
     *
     * @throws ApiV1Exception
     */
    public function playUrl($id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        $user = Auth::user();
        if (! $user->canSeeThisVideo($video)) {
            throw new ApiV1Exception('当前视频无法观看');
        }

        return $video->getPlayInfo();
    }

    /**
     * 视频下的评论分页列表.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function comments(Request $request, $id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        $comments = $video->comments()
            ->orderByDesc('created_at')
            ->paginate($request->input('page_size', 10));

        return VideoCommentResource::collection($comments);
    }

    /**
     * 视频评论处理.
     *
     * @param CourseOrVideoCommentCreateRequest $request
     * @param $id
     *
     * @return VideoCommentResource
     *
     * @throws \Throwable
     */
    public function commentHandler(CourseOrVideoCommentCreateRequest $request, $id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        $comment = $video->commentHandler($request->input('content'));
        throw_if(! $comment, new ApiV1Exception('系统错误'));

        return new VideoCommentResource($comment);
    }
}
