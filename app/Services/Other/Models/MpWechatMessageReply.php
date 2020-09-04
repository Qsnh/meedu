<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpWechatMessageReply extends Model
{
    use SoftDeletes;

    public const TYPE_TEXT = 'text';
    public const TYPE_EVENT = 'event';

    protected $table = 'mp_wechat_message_reply';

    protected $fillable = [
        'type', 'event_type', 'event_key', 'rule', 'reply_content',
        'hit_times', 'last_hit_at',
    ];
}
