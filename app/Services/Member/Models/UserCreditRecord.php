<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCreditRecord extends Model
{
    use SoftDeletes, HasFactory;

    public const FIELD_CREDIT1 = 'credit1';
    public const FIELD_CREDIT2 = 'credit2';

    protected $table = 'user_credit_records';

    protected $fillable = [
        'user_id', 'field', 'sum', 'remark',
    ];
}
