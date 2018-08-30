<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Course extends Model
{
    use SoftDeletes;

    const SHOW_YES = 1;
    const SHOW_NO = -1;

    protected $table = 'courses';

    protected $fillable = [
        'user_id', 'title', 'slug', 'thumb', 'charge',
        'short_description', 'description', 'seo_keywords',
        'seo_description', 'published_at', 'is_show',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    /**
     * 该课程所属用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 购买课程的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function buyUsers()
    {
        return $this->belongsToMany(User::class, 'user_course', 'course_id', 'user_id')->withPivot('charge', 'created_at');
    }

    /**
     * 该课程下面的视频
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'course_id', 'id');
    }

    /**
     * 作用域：显示
     * @param $query
     * @return mixed
     */
    public function scopeShow($query)
    {
        return $query->where('is_show', self::SHOW_YES);
    }

    /**
     * 作用域：不显示
     * @param $query
     * @return mixed
     */
    public function scopeNotShow($query)
    {
        return $query->where('is_show', self::SHOW_NO);
    }

    /**
     * 作用域：上线的视频
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', date('Y-m-d H:i:s'));
    }

    public function getEditUrlAttribute()
    {
        return route('backend.course.edit', $this);
    }

    public function getDestroyUrlAttribute()
    {
        return route('backend.course.destroy', $this);
    }

    /**
     * 作用域：关键词搜索
     * @param $query
     * @param string $keywords
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
        return (new \Parsedown)->text($this->description);
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return Cache::remember("course_{$this->id}_videos", 360, function () {
            return $this->videos()->published()->show()->orderBy('published_at', 'asc')->get();
        });
    }

    /**
     * 评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(CourseComment::class, 'course_id');
    }

    /**
     * 课程的观看URL
     * @return string
     */
    public function seeUrl()
    {
        $firstVideo = $this->videos()->orderByDesc('published_at')->first();
        return $firstVideo ? route('video.show', [$this->id, $firstVideo->id, $firstVideo->slug]) : 'javascript:void(0)';
    }

}
