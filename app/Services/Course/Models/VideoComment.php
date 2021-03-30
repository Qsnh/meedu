<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Course\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class VideoComment extends Base
{
    use SoftDeletes;

    protected $table = 'video_comments';

    protected $fillable = [
        'user_id', 'video_id', 'original_content', 'render_content',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }
}
