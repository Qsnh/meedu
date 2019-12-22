<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Course\Models;

class Video extends Base
{
    const IS_SHOW_YES = 1;
    const IS_SHOW_NO = -1;

    protected $table = 'videos';

    protected $fillable = [
        'user_id', 'course_id', 'title', 'slug',
        'url', 'view_num', 'short_description', 'original_desc', 'render_desc',
        'seo_keywords', 'seo_description', 'published_at',
        'is_show', 'charge', 'aliyun_video_id',
        'chapter_id', 'duration', 'tencent_video_id',
    ];

    /**
     * 所属课程.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * 作用域：显示.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeShow($query)
    {
        return $query->where('is_show', self::IS_SHOW_YES);
    }

    /**
     * 作用域：上线的视频.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', date('Y-m-d H:i:s'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(VideoComment::class, 'video_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class, 'chapter_id');
    }
}
