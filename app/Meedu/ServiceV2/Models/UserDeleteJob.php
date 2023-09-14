<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDeleteJob extends Model
{
    use HasFactory;

    protected $table = 'user_delete_jobs';

    protected $fillable = [
        'user_id', 'mobile', 'submit_at', 'expired_at',
    ];

    public $timestamps = false;
}
