<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Course\Services;

use App\Events\VideoCommentEvent;
use Illuminate\Support\Facades\Auth;
use App\Services\Course\Models\VideoComment;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;

class VideoCommentService implements VideoCommentServiceInterface
{
    /**
     * @param int $courseId
     * @return array
     */
    public function videoComments(int $courseId): array
    {
        $comments = VideoComment::whereVideoId($courseId)->orderByDesc('id')->limit(200)->get()->toArray();

        return $comments;
    }

    /**
     * @param int $videoId
     * @param string $originalContent
     *
     * @return array
     */
    public function create(int $videoId, string $originalContent): array
    {
        $comment = VideoComment::create([
            'user_id' => Auth::id(),
            'video_id' => $videoId,
            'original_content' => $originalContent,
            'render_content' => $originalContent,
        ]);

        event(new VideoCommentEvent($videoId, $comment['id']));

        return $comment->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function find(int $id): array
    {
        return VideoComment::findOrFail($id)->toArray();
    }
}
