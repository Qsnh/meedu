<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\UpgradeLog;

use App\Services\Course\Models\Video;
use App\Services\Base\Model\AppConfig;
use App\Services\Course\Models\Course;
use App\Services\Other\Models\SearchRecord;

class UpgradeToV45
{
    public static function handle()
    {
        self::courseAndVideoMigrateMeiliSearch();
        self::removeConfig();
        self::configRename();
    }

    public static function removeConfig()
    {
        AppConfig::query()
            ->whereIn('key', [
                // 全局js
                'meedu.system.js',
                // PC全局css
                'meedu.system.css.pc',
                // H5全局css
                'meedu.system.css.h5',
                // 会员注册默认激活
                'meedu.member.is_active_default',

                // SEO
                'meedu.seo.index.title',
                'meedu.seo.index.keywords',
                'meedu.seo.index.description',
                'meedu.seo.course_list.title',
                'meedu.seo.course_list.keywords',
                'meedu.seo.course_list.description',
                'meedu.seo.role_list.title',
                'meedu.seo.role_list.keywords',
                'meedu.seo.role_list.description',

                // 其它配置
                'meedu.other.course_list_page_size',
                'meedu.other.video_list_page_size',

                'meedu.system.editor',
            ])
            ->delete();
    }

    public static function configRename()
    {
        AppConfig::query()->where('key', 'meedu.system.icp')->update(['name' => 'ICP备案号']);
    }

    public static function courseAndVideoMigrateMeiliSearch()
    {
        $courses = Course::query()
            ->select([
                'id', 'title', 'charge', 'thumb', 'short_description', 'original_desc',
            ])
            ->get();
        foreach ($courses as $course) {
            $exists = SearchRecord::query()->where('resource_id', $course['id'])->where('resource_type', 'vod')->exists();
            if ($exists) {
                continue;
            }

            SearchRecord::create([
                'resource_type' => 'vod',
                'resource_id' => $course['id'],
                'title' => $course['title'],
                'charge' => $course['charge'],
                'thumb' => $course['thumb'],
                'short_desc' => $course['short_description'],
                'desc' => $course['original_desc'],
            ]);
        }

        $videos = Video::query()
            ->select(['id', 'title', 'charge'])
            ->get();
        foreach ($videos as $video) {
            $exists = SearchRecord::query()->where('resource_id', $video['id'])->where('resource_type', 'video')->exists();
            if ($exists) {
                continue;
            }

            SearchRecord::create([
                'resource_type' => 'video',
                'resource_id' => $video['id'],
                'title' => $video['title'],
                'charge' => $video['charge'],
                'thumb' => '',
                'short_desc' => '',
                'desc' => '',
            ]);
        }
    }
}