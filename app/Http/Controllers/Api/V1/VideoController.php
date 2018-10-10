<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiV1Exception;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;
use App\Http\Resources\VideoCommentResource;
use App\Http\Resources\VideoRecourse;
use App\Models\Video;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    public function show($id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        return new VideoRecourse($video);
    }

    public function playUrl($id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        $user = Auth::user();
        if (! $user->canSeeThisVideo($video)) {
            throw new ApiV1Exception('当前视频无法观看');
        }

        return aliyun_play_url($video);
    }

    public function comments(Request $request, $id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        $comments = $video->comments()
            ->orderByDesc('created_at')
            ->paginate($request->input('page_size', 10));
        return VideoCommentResource::collection($comments);
    }

    public function commentHandler(CourseOrVideoCommentCreateRequest $request, $id)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        $comment = $video->commentHandler($request->input('content'));
        throw_if(! $comment, new ApiV1Exception('系统错误'));
        return new VideoCommentResource($comment);
    }

}