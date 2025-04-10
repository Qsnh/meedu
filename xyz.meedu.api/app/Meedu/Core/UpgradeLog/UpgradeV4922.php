<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Constant\BusConstant;
use App\Constant\TableConstant;
use Illuminate\Support\Facades\DB;
use App\Meedu\ServiceV2\Models\Comment;
use App\Models\AdministratorPermission;
use App\Services\Course\Models\VideoComment;
use App\Services\Course\Models\CourseComment;

class UpgradeV4922
{
    public static function handle()
    {
        self::commentMigrate();
        self::deletePermissions();
    }

    private static function deletePermissions()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'course_comment',
                'course_comment.destroy',
                'course_comment.check',
                'video_comment',
                'video_comment.destroy',
                'video_comment.check',
            ])
            ->delete();
    }

    private static function commentMigrate()
    {
        // 课程评论迁移
        self::migrateCourseComments();
        // 视频评论迁移
        self::migrateVideoComments();
    }

    private static function migrateCourseComments()
    {
        $chunkSize = 100;
        CourseComment::query()
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('comments')
                    ->whereRaw('comments.rid = ' . TableConstant::TABLE_COURSE_COMMENTS . '.course_id')
                    ->whereRaw('comments.rt = ' . BusConstant::COMMENT_RT_VOD_COURSE);
            })
            ->chunk($chunkSize, function ($comments) {
                foreach ($comments as $comment) {
                    Comment::create([
                        'parent_id' => 0,
                        'reply_id' => 0,
                        'user_id' => $comment['user_id'],
                        'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
                        'rid' => $comment['course_id'],
                        'content' => $comment['original_content'] ? strip_tags($comment['original_content']) : '',
                        'ip' => $comment['ip'],
                        'ip_province' => $comment['ip_province'],
                        'is_check' => $comment['is_check'],
                        'check_reason' => '',
                        'created_at' => $comment['created_at'],
                    ]);
                }
            });
    }

    private static function migrateVideoComments()
    {
        $chunkSize = 100;
        VideoComment::query()
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('comments')
                    ->whereRaw('comments.rid = ' . TableConstant::TABLE_VIDEO_COMMENTS . '.video_id')
                    ->whereRaw('comments.rt = ' . BusConstant::COMMENT_RT_VOD_COURSE_VIDEO);
            })
            ->chunk($chunkSize, function ($comments) {
                foreach ($comments as $comment) {
                    Comment::create([
                        'parent_id' => 0,
                        'reply_id' => 0,
                        'user_id' => $comment['user_id'],
                        'rt' => BusConstant::COMMENT_RT_VOD_COURSE_VIDEO,
                        'rid' => $comment['video_id'],
                        'content' => $comment['original_content'] ? strip_tags($comment['original_content']) : '',
                        'ip' => $comment['ip'],
                        'ip_province' => $comment['ip_province'],
                        'is_check' => $comment['is_check'],
                        'check_reason' => '',
                        'created_at' => $comment['created_at'],
                    ]);
                }
            });
    }
}
