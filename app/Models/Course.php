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

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Course.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title             名
 * @property string $slug              slug
 * @property string $thumb             封面
 * @property int $charge            收费
 * @property string $short_description 简短介绍
 * @property string $description       课程介绍
 * @property string $seo_keywords      SEO关键字
 * @property string $seo_description   SEO描述
 * @property string|null $published_at      上线时间
 * @property int $is_show           1显示,-1隐藏
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\User[] $buyUsers
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\CourseChapter[] $chapters
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\CourseComment[] $comments
 * @property \App\User $user
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course keywords($keywords)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course notShow()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course show()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereIsShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course withoutTrashed()
 * @mixin \Eloquent
 */
class Course extends Model
{
    use SoftDeletes;

    const SHOW_YES = 1;
    const SHOW_NO = -1;

    const REC_YES = 1;
    const REC_NO = 0;

    protected $table = 'courses';

    protected $fillable = [
        'user_id', 'title', 'slug', 'thumb', 'charge',
        'short_description', 'original_desc', 'render_desc', 'seo_keywords',
        'seo_description', 'published_at', 'is_show', 'category_id',
        'is_rec',
    ];

    /**
     * 该课程所属用户.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id');
    }

    /**
     * 购买课程的用户.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function buyUsers()
    {
        return $this->belongsToMany(User::class, 'user_course', 'course_id', 'user_id')
            ->withPivot('charge', 'created_at');
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAllPublishedAndShowVideosCache()
    {
        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->getAllPublishedAndShowVideos();
        }

        return Cache::remember(
            "course_{$this->id}_videos",
            config('meedu.system.cache.expire', 60),
            function () {
                return $this->getAllPublishedAndShowVideos();
            }
        );
    }

    /**
     * 获取所有已出版且显示的视频.
     *
     * @return mixed
     */
    public function getAllPublishedAndShowVideos()
    {
        return $this->videos()
            ->published()
            ->show()
            ->orderBy('published_at')
            ->get();
    }

    /**
     * 章节缓存.
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getChaptersCache()
    {
        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->getChapters();
        }

        return Cache::remember(
            "course_{$this->id}_chapter_videos",
            config('meedu.system.cache.expire', 60),
            function () {
                return $this->getChapters();
            }
        );
    }

    /**
     * 获取章节
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChapters()
    {
        return $this->chapters()->orderBy('sort')->get();
    }

    /**
     * 是否存在缓存.
     *
     * @return bool|mixed
     */
    public function hasChaptersCache()
    {
        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->hasChapters();
        }

        return Cache::remember(
            "course_{$this->id}_has_chapters",
            config('meedu.system.cache.expire', 60),
            function () {
                return $this->hasChapters();
            }
        );
    }

    /**
     * 是否存在章节
     *
     * @return bool
     */
    public function hasChapters()
    {
        return $this->chapters()->exists();
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
     * 课程的观看URL.
     *
     * @return string
     */
    public function seeUrl()
    {
        $firstVideo = $this->videos()
            ->published()
            ->show()
            ->orderByDesc('published_at')
            ->first();

        return $firstVideo ?
            route('video.show', [$this->id, $firstVideo->id, $firstVideo->slug]) :
            'javascript:void(0)';
    }

    /**
     * 获取当前课程最近加入的用户[缓存].
     *
     * @return mixed
     */
    public function getNewJoinMembersCache()
    {
        $course = $this;
        if (!config('meedu.system.cache.status')) {
            return $this->getNewJoinMembers();
        }

        return Cache::remember(
            "course:{$course->id}:new_join_member",
            config('member.system.cache.expire', 60),
            function () use ($course) {
                return $course->getNewJoinMembers();
            }
        );
    }

    /**
     * 获取当前课程最近加入的用户.
     *
     * @return mixed
     */
    public function getNewJoinMembers()
    {
        return $this->buyUsers()->orderByDesc('pivot_created_at')->limit(10)->get();
    }

    /**
     * 评论处理.
     *
     * @param string $content
     *
     * @return false|Model
     */
    public function commentHandler(string $content)
    {
        $comment = $this->comments()->save(new CourseComment([
            'user_id' => Auth::id(),
            'content' => $content,
        ]));

        return $comment;
    }

    /**
     * 获取是否显示状态，显示返回真
     *
     * @return bool
     */
    public function getIsShow()
    {
        return $this->is_show == self::SHOW_YES;
    }
}
