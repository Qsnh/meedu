<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CourseChapter.
 *
 * @property int                                                          $id
 * @property int                                                          $course_id
 * @property string                                                       $title
 * @property \Illuminate\Support\Carbon|null                              $created_at
 * @property \Illuminate\Support\Carbon|null                              $updated_at
 * @property int                                                          $sort
 * @property \App\Models\Course                                           $course
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseChapter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CourseChapter extends Model
{
    protected $table = 'course_chapter';

    protected $fillable = [
        'course_id', 'title', 'sort',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'chapter_id');
    }

    /**
     * 获取视频缓存.
     *
     * @return mixed
     */
    public function getVideosCache()
    {
        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->getVideos();
        }
        $that = $this;

        return Cache::remember(
            "chapter_{$this->id}_videos",
            config('meedu.system.cache.expire', 60),
            function () use ($that) {
                return $that->getVideos();
            }
        );
    }

    /**
     * 获取已出版且显示的视频.
     *
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos()
            ->published()
            ->show()
            ->orderBy('published_at')
            ->get();
    }
}
