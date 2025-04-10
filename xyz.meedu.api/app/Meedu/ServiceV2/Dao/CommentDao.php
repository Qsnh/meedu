<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Illuminate\Support\Arr;
use App\Meedu\ServiceV2\Models\Comment;

class CommentDao implements CommentDaoInterface
{
    public function getComments(int $rt, int $rid, int $limit = 5): array
    {
        // 1. 查询主评论
        $comments = Comment::query()
            ->select([
                'id', 'parent_id', 'reply_id', 'user_id', 'content',
                'ip_province', 'is_check', 'created_at',
            ])
            ->withCount(['replies'])
            ->where('rt', $rt)
            ->where('rid', $rid)
            ->where('parent_id', 0)
            ->orderByDesc('id')
            ->limit($limit)
            ->get();

        if ($comments->isEmpty()) {
            return [];
        }

        // 2. 获取评论IDs
        $parentIds = $comments->pluck('id')->toArray();

        // 3. 查询回复（两步优化）
        // 3.1 获取每个主评论的最新3条回复的ID
        $replyIds = Comment::query()
            ->select(['id', 'parent_id'])
            ->whereIn('parent_id', $parentIds)
            ->orderBy('parent_id')
            ->orderByDesc('id')
            ->get()
            ->groupBy('parent_id')
            ->map(function ($groupedReplies) {
                return $groupedReplies->take(3)->pluck('id');
            })
            ->flatten()
            ->toArray();

        // 3.2 查询完整回复数据
        $replies = empty($replyIds) ? collect() : Comment::query()
            ->select([
                'id', 'parent_id', 'reply_id', 'user_id', 'content',
                'ip_province', 'is_check', 'created_at',
            ])
            ->whereIn('id', $replyIds)
            ->with(['replyComment:id,user_id,reply_id'])
            ->orderBy('parent_id')
            ->orderByDesc('id')
            ->get()
            ->groupBy('parent_id');

        // 4. 组装数据
        return $comments
            ->map(function ($comment) use ($replies) {
                $commentArray = $comment->toArray();
                $commentArray['replies'] = $replies->get($comment->id, collect())->values()->toArray();
                return $commentArray;
            })
            ->toArray();
    }

    public function getAllChildComments(int $rt, int $rid, int $parentId): array
    {
        $query = Comment::query()
            ->select([
                'id', 'parent_id', 'reply_id', 'user_id', 'content',
                'ip_province', 'is_check', 'created_at',
            ]);

        if (0 === $parentId) {
            // 1. 查询主评论
            $comments = $query
                ->withCount(['replies'])
                ->where('rt', $rt)
                ->where('rid', $rid)
                ->where('parent_id', $parentId)
                ->orderByDesc('id')
                ->get();

            if ($comments->isEmpty()) {
                return [];
            }

            // 2. 获取评论IDs
            $parentIds = $comments->pluck('id')->toArray();

            // 3. 查询回复（两步优化）
            // 3.1 获取每个主评论的最新3条回复的ID
            $replyIds = Comment::query()
                ->select(['id', 'parent_id'])
                ->whereIn('parent_id', $parentIds)
                ->whereNull('deleted_at')
                ->orderBy('parent_id')
                ->orderByDesc('id')
                ->get()
                ->groupBy('parent_id')
                ->map(function ($groupedReplies) {
                    return $groupedReplies->take(3)->pluck('id');
                })
                ->flatten()
                ->toArray();

            // 3.2 查询完整回复数据
            $replies = empty($replyIds) ? collect() : Comment::query()
                ->select([
                    'id', 'parent_id', 'reply_id', 'user_id', 'content',
                    'ip_province', 'is_check', 'created_at',
                ])
                ->whereIn('id', $replyIds)
                ->with(['replyComment:id,user_id,reply_id'])
                ->orderBy('parent_id')
                ->orderByDesc('id')
                ->get()
                ->groupBy('parent_id');

            // 4. 组装数据
            return $comments
                ->map(function ($comment) use ($replies) {
                    $commentArray = $comment->toArray();
                    $commentArray['replies'] = $replies->get($comment->id, collect())->values()->toArray();
                    return $commentArray;
                })
                ->toArray();
        } else {
            // 子评论查询保持不变
            return $query
                ->with(['replyComment:id,user_id,reply_id'])
                ->where('rt', $rt)
                ->where('rid', $rid)
                ->where('parent_id', $parentId)
                ->orderByDesc('id')
                ->get()
                ->toArray();
        }
    }

    public function getCommentsByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }
        return Comment::query()
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id')
            ->toArray();
    }

    public function create(array $data): array
    {
        $comment = Comment::create([
            'user_id' => $data['user_id'],
            'rt' => $data['rt'],
            'rid' => $data['rid'],
            'parent_id' => $data['parent_id'] ?? 0,
            'reply_id' => $data['reply_id'] ?? 0,
            'content' => $data['content'],
            'ip' => $data['ip'],
            'ip_province' => $data['province'],
            'is_check' => 0,
        ]);

        return $comment->toArray();
    }

    public function findById(int $id, array $fields, array $params = []): array
    {
        $filterBlacklist = Arr::except($params, ['parent_id']);
        if ($filterBlacklist) {
            throw new \Exception(__('下面参数 :params 不支持过滤', ['params' => implode(',', array_keys($filterBlacklist))]));
        }
        $comment = Comment::query()
            ->select($fields)
            ->when(isset($params['parent_id']), function ($query) use ($params) {
                $query->where('parent_id', $params['parent_id']);
            })
            ->where('id', $id)
            ->first();
        return $comment ? $comment->toArray() : [];
    }

    public function getTotalCount(int $rt, int $rid): int
    {
        return Comment::query()
            ->where('rt', $rt)
            ->where('rid', $rid)
            ->where('parent_id', 0)
            ->count();
    }

    public function deleteBy(array $array, bool $force = false): void
    {
        if (!$array) {
            throw new \Exception(__('参数 $array 不能为空'));
        }

        $exceptList = Arr::except($array, ['user_id', 'rt', 'rid']);
        if ($exceptList) {
            throw new \Exception(__(':method 的 $array 参数不支持指定 :params', ['method' => __METHOD__, 'params' => implode(',', array_keys($exceptList))]));
        }

        $query = Comment::query()
            ->when(isset($array['user_id']), function ($query) use ($array) {
                $query->where('user_id', $array['user_id']);
            })
            ->when(isset($array['rt']), function ($query) use ($array) {
                $query->where('rt', $array['rt']);
            })
            ->when(isset($array['rid']), function ($query) use ($array) {
                $query->where('rid', $array['rid']);
            });

        if ($force) {
            $query->forceDelete();
        } else {
            $query->delete();
        }
    }
}
