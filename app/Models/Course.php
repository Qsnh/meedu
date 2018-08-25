<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $query->where('published_at', '>=', date('Y-m-d H:i:s'));
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

}
