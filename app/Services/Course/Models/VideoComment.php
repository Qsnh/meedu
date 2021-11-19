<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoComment extends Base
{
    use SoftDeletes,HasFactory;

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
