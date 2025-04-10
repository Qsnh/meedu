<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'parent_id', 'reply_id', 'user_id', 'rt', 'rid', 'content', 'ip', 'ip_province', 'is_check', 'check_reason',
        'created_at',
    ];

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parentComment()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function replyComment()
    {
        return $this->belongsTo(self::class, 'reply_id', 'id');
    }

}
