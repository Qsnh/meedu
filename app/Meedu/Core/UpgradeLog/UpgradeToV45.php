<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Services\Course\Models\Video;
use App\Services\Base\Model\AppConfig;
use App\Services\Course\Models\Course;
use App\Models\AdministratorPermission;
use App\Services\Other\Models\SearchRecord;

class UpgradeToV45
{
    public static function handle()
    {
        self::removeConfig();
        self::configRename();
        self::removePermission();
        self::updateImageDiskOptions();
        self::updateSmsOptions();
        self::ampaConfigFixed();
    }

    public static function removePermission()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'indexBanner',
                'indexBanner.create',
                'indexBanner.store',
                'indexBanner.edit',
                'indexBanner.update',
                'indexBanner.destroy',
            ])
            ->delete();
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

                // 腾讯云超级播放器配置
                'meedu.system.player.tencent_pcfg',

                // 语言配置
                'meedu.system.lang',
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

    public static function updateImageDiskOptions()
    {
        AppConfig::query()
            ->where('key', 'meedu.upload.image.disk')
            ->update([
                'option_value' => json_encode([
                    [
                        'title' => '本地',
                        'key' => 'public',
                    ],
                    [
                        'title' => '阿里云OSS',
                        'key' => 'oss',
                    ],
                    [
                        'title' => '腾讯云COS',
                        'key' => 'cos',
                    ],
                    [
                        'title' => '七牛云',
                        'key' => 'qiniu',
                    ],
                ]),
            ]);
    }

    public static function updateSmsOptions()
    {
        AppConfig::query()
            ->where('key', 'meedu.system.sms')
            ->update([
                'option_value' => json_encode([
                    [
                        'title' => '阿里云',
                        'key' => 'aliyun',
                    ],
                    [
                        'title' => '腾讯云',
                        'key' => 'tencent',
                    ],
                    [
                        'title' => '云片',
                        'key' => 'yunpian',
                    ],
                ]),
            ]);
    }

    public static function ampaConfigFixed()
    {
        AppConfig::query()->where('key', 'meedu.services.imap.key')->delete();

        $data = [
            'group' => '高德地图',
            'name' => '应用Key',
            'field_type' => 'text',
            'sort' => 1,
            'key' => 'meedu.services.amap.key',
            'value' => '',
            'is_private' => 1,
        ];

        if (!AppConfig::query()->where('key', $data['key'])->exists()) {
            AppConfig::create($data);
        }
    }
}
