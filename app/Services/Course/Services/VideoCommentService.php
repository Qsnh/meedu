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

use App\Services\Course\Models\VideoComment;
use App\Services\Base\Interfaces\RenderServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;
use Illuminate\Support\Facades\Auth;

class VideoCommentService implements VideoCommentServiceInterface
{
    protected $renderService;

    public function __construct(RenderServiceInterface $renderService)
    {
        $this->renderService = $renderService;
    }

    public function videoComments(int $courseId): array
    {
        $comments = VideoComment::whereVideoId($courseId)->orderBy('id')->get()->toArray();

        return $comments;
    }

    /**
     * @param int    $videoId
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

        return $comment->toArray();
    }
}
