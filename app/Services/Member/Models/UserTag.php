<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;

class UserTag extends Model
{
    protected $table = TableConstant::TABLE_USER_TAGS;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, TableConstant::TABLE_USER_TAG, 'tag_id', 'user_id');
    }
}
