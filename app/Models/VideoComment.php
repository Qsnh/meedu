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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VideoComment.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $video_id
 * @property string|null                     $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $deleted_at
 * @property \App\User                       $user
 * @property \App\Models\Video               $video
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment des()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoComment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoComment whereVideoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoComment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoComment withoutTrashed()
 * @mixin \Eloquent
 */
class VideoComment extends Model
{
    use SoftDeletes;
    use Scope;

    protected $table = 'video_comments';

    protected $fillable = [
        'user_id', 'video_id', 'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function getContent()
    {
        return markdown_to_html($this->content);
    }
}
