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
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCreditRecord extends Model
{
    use SoftDeletes;

    public const FIELD_CREDIT1 = 'credit1';
    public const FIELD_CREDIT2 = 'credit2';

    protected $table = 'user_credit_records';

    protected $fillable = [
        'user_id', 'field', 'sum', 'remark',
    ];
}
