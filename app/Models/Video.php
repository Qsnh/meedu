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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
        'is_show', 'charge', 'aliyun_video_id',
        'chapter_id',
    ];

    /**
     * 所属用户.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

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

    /**
     * 购买课程的用户.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function buyUsers()
    {
        return $this->belongsToMany(User::class, 'user_video', 'video_id', 'user_id')
            ->withPivot('charge', 'created_at');
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
        $comment = $this->comments()->save(new VideoComment([
            'user_id' => Auth::id(),
            'content' => $content,
        ]));

        return $comment;
    }

    /**
     * 获取视频的播放地址[阿里云|本地].
     *
     * @return array
     */
    public function getPlayInfo()
    {
        if ($this->aliyun_video_id != '') {
            $playInfo = aliyun_play_url($this);
            Log::info(json_encode($playInfo));

            return $playInfo;
        }

        return [
            [
                'format' => pathinfo($this->url, PATHINFO_EXTENSION),
                'url' => $this->url,
                'duration' => 0,
            ],
        ];
    }

    /**
     * 获取视频播放地址
     *
     * @return mixed
     */
    public function getPlayUrl()
    {
        if ($this->url) {
            return $this->url;
        }
        $playInfo = aliyun_play_url($this);
        Log::info($playInfo);

        return isset($playInfo[0]) ? $playInfo[0]['url'] : '';
    }
}
