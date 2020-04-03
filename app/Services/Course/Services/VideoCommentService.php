<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Course\Services;

use App\Events\VideoCommentEvent;
use Illuminate\Support\Facades\Auth;
use App\Services\Course\Models\VideoComment;
use App\Services\Base\Interfaces\RenderServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;

class VideoCommentService implements VideoCommentServiceInterface
{
    protected $renderService;

    public function __construct(RenderServiceInterface $renderService)
    {
        $this->renderService = $renderService;
    }

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
        $renderContent = $this->renderService->render($originalContent);
        $comment = VideoComment::create([
            'user_id' => Auth::id(),
            'video_id' => $videoId,
            'original_content' => $originalContent,
            'render_content' => $renderContent,
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
