<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;
use App\Models\Video;
use App\Http\Controllers\Controller;
use App\Models\VideoComment;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    public function show($courseId, $id, $slug)
    {
        $video = Video::with(['comments', 'user', 'comments.user'])
            ->published()
            ->show()
            ->whereId($id)
            ->firstOrFail();
        return view('frontend.video.show', compact('video'));
    }

    public function commentHandler(CourseOrVideoCommentCreateRequest $request, $videoId)
    {
        $video = Video::findOrFail($videoId);

        $comment = $video->comments()->save(new VideoComment([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]));

        $comment ? flash('评论成功', 'success') : flash('评论失败');

        return back();
    }

}
