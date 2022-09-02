<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseUserRecord extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = TableConstant::TABLE_COURSE_USER_RECORDS;

    protected $fillable = [
        'course_id', 'user_id', 'is_watched', 'watched_at', 'progress',
    ];
}
