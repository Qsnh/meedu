<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Exceptions\ServiceException;
use App\Meedu\ServiceV2\Dao\CommentDao;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentService implements CommentServiceInterface
{
    protected $commentDao;

    public function __construct(CommentDao $commentDao)
    {
        $this->commentDao = $commentDao;
    }

    public function comments(int $rt, int $rid): array
    {
        $comments = $this->commentDao->getComments($rt, $rid);
        if (!$comments) {
            return [
                'data' => [],
                'total' => 0
            ];
        }

        // 处理一级评论和其回复的内容隐藏
        foreach ($comments as $commentKey => $comment) {
            if ($comment['is_check'] !== 1) {
                $comments[$commentKey]['content'] = '';
            }

            if ($comment['replies']) {
                foreach ($comment['replies'] as $replyKey => $reply) {
                    if ($reply['is_check'] !== 1) {
                        $comment['replies'][$replyKey]['content'] = '';
                    }
                }
            }
        }

        $total = $this->commentDao->getTotalCount($rt, $rid);

        return [
            'data' => array_values($comments),
            'total' => $total
        ];
    }

    public function replies(int $rt, int $rid, int $parentId): array
    {
        $data = $this->commentDao->getAllChildComments($rt, $rid, $parentId);

        foreach ($data as $replyKey => $tmpReplyItem) {
            if ($tmpReplyItem['is_check'] !== 1) {
                $data[$replyKey]['content'] = '';
            }

            if (isset($tmpReplyItem['replies']) && $tmpReplyItem['replies']) {
                foreach ($tmpReplyItem['replies'] as $itemKey => $tmpItem) {
                    if ($tmpItem['is_check'] !== 1) {
                        $data[$replyKey]['replies'][$itemKey]['content'] = '';
                    }
                }
            }
        }

        return $data;
    }

    public function create(array $data): array
    {
        // 检查父评论是否存在
        if ($data['parent_id']) {
            $parentComment = $this->commentDao->findById($data['parent_id'], ['id', 'is_check']);
            if (!$parentComment) {
                throw new ModelNotFoundException();
            }
            if (1 !== $parentComment['is_check']) {
                throw new ServiceException(__('评论审核中'));
            }
        }

        // 检查回复的评论是否存在
        if ($data['reply_id']) {
            $replyComment = $this->commentDao->findById($data['reply_id'], ['id', 'is_check'], ['parent_id' => $parentComment['id']]);
            if (!$replyComment) {
                throw new ModelNotFoundException();
            }
        }

        $comment = $this->commentDao->create($data);

        return [
            'id' => $comment['id'],
            'content' => '',
            'created_at' => $comment['created_at'],
            'parent_id' => $comment['parent_id'],
            'reply_id' => $comment['reply_id'],
            'ip_province' => $comment['ip_province'],
            'is_check' => $comment['is_check'],
        ];
    }

    public function deleteUserDATA(int $userId): void
    {
        $this->commentDao->deleteBy(['user_id' => $userId], true);
    }

    public function deleteResourceComment(string $rt, int $rid): void
    {
        $this->commentDao->deleteBy([
            'rt' => $rt,
            'rid' => $rid,
        ]);
    }


}
