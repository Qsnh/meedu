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

/**
 * App\Models\Socialite.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property string                          $app
 * @property string                          $app_user_id
 * @property string                          $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\User                       $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite whereApp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Socialite whereUserId($value)
 * @mixin \Eloquent
 */
class Socialite extends Model
{
    protected $table = 'socialite';

    protected $fillable = [
        'user_id', 'app', 'app_user_id', 'data',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
