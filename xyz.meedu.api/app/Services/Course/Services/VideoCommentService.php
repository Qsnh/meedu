<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Services;

use App\Meedu\Utils\IP;
use App\Events\VideoCommentEvent;
use App\Services\Course\Models\VideoComment;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;

class VideoCommentService implements VideoCommentServiceInterface
{

    public function videoComments(int $videoId): array
    {
        return VideoComment::query()
            ->where('video_id', $videoId)
            ->orderByDesc('id')
            ->limit(200)
            ->get()
            ->toArray();
    }

    public function create(int $userId, int $videoId, string $originalContent): array
    {
        $ip = request()->getClientIp();

        $comment = VideoComment::create([
            'user_id' => $userId,
            'video_id' => $videoId,
            'original_content' => $originalContent,
            'render_content' => $originalContent,
            'ip' => $ip,
            'ip_province' => IP::queryProvince($ip),
            'is_check' => 0,
        ]);

        event(new VideoCommentEvent($videoId, $comment['id']));

        return $comment->toArray();
    }

}
