<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;

class UserRemark extends Model
{
    protected $table = 'user_remarks';

    protected $fillable = [
        'remark', 'user_id',
    ];
}
