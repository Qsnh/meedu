<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
