<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;

class Socialite extends Model
{
    protected $table = 'socialite';

    protected $fillable = [
        'user_id', 'app', 'app_user_id', 'data', 'union_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
