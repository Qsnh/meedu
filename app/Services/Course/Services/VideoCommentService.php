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
use App\Services\Base\Services\RenderService;

class VideoCommentService
{
    protected $renderService;

    public function __construct(RenderService $renderService)
    {
        $this->renderService = $renderService;
    }

    public function videoComments(int $courseId): array
    {
        $comments = VideoComment::whereVideoId($courseId)->orderBy('id')->get()->toArray();

        return $comments;
    }

    /**
     * @param int    $userId
     * @param int    $videoId
     * @param string $originalContent
     *
     * @return array
     */
    public function create(int $userId, int $videoId, string $originalContent): array
    {
        $renderContent = $this->renderService->render($originalContent);
        $comment = VideoComment::create([
            'user_id' => $userId,
            'video_id' => $videoId,
            'original_content' => $originalContent,
            'render_content' => $renderContent,
        ]);

        return $comment->toArray();
    }
}
