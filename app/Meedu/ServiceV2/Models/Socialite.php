<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Services\Member\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Socialite extends Model
{
    use HasFactory;

    protected $table = 'socialite';

    protected $fillable = [
        'user_id', 'app', 'app_user_id', 'data', 'union_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
