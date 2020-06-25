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

use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Base
{
    use SoftDeletes;

    public const SHOW_YES = 1;
    public const SHOW_NO = -1;

    public const REC_YES = 1;
    public const REC_NO = 0;

    public const IS_FREE_YES = 1;
    public const IS_FREE_NO = 0;

    public const COMMENT_STATUS_CLOSE = 0;
    public const COMMENT_STATUS_ALL = 1;
    public const COMMENT_STATUS_ONLY_PAID = 2;

    protected $table = 'courses';

    protected $fillable = [
        'user_id', 'title', 'slug', 'thumb', 'charge',
        'short_description', 'original_desc', 'render_desc', 'seo_keywords',
        'seo_description', 'published_at', 'is_show', 'category_id',
        'is_rec', 'user_count', 'is_free', 'comment_status',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id');
    }

    /**
     * 该课程下面的视频.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'course_id', 'id');
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
        return $query->where('is_show', self::SHOW_YES);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecommend($query)
    {
        return $query->where('is_rec', self::REC_YES);
    }


    /**
     * 作用域：不显示.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotShow($query)
    {
        return $query->where('is_show', self::SHOW_NO);
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
     * 作用域：关键词搜索.
     *
     * @param $query
     * @param string $keywords
     *
     * @return mixed
     */
    public function scopeKeywords($query, string $keywords)
    {
        $keywords && $query->where('title', 'like', "%{$keywords}%");

        return $query;
    }

    /**
     * 评论.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(CourseComment::class, 'course_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }
}
