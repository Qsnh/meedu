<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoComment extends Base
{
    use SoftDeletes, HasFactory;

    protected $table = TableConstant::TABLE_VIDEO_COMMENTS;

    protected $fillable = [
        'user_id', 'video_id', 'original_content', 'render_content', 'ip', 'ip_province',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }
}
