<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    const IS_SHOW_YES = 1;
    const IS_SHOW_NO = -1;

    protected $table = 'videos';

    protected $fillable = [
        'user_id', 'course_id', 'title', 'slug',
        'url', 'view_num', 'short_description', 'description',
        'seo_keywords', 'seo_description', 'published_at',
        'is_show', 'charge',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    /**
     * 所属用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 所属课程
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * 作用域：显示
     * @param $query
     * @return mixed
     */
    public function scopeShow($query)
    {
        return $query->where('is_show', self::IS_SHOW_YES);
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
        return route('backend.video.edit', $this);
    }

    public function getDestroyUrlAttribute()
    {
        return route('backend.video.destroy', $this);
    }

    public function comments()
    {
        return $this->hasMany(VideoComment::class, 'video_id');
    }

    /**
     * 购买课程的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function buyUsers()
    {
        return $this->belongsToMany(User::class, 'user_video', 'video_id', 'user_id')->withPivot('charge', 'created_at');
    }

}
