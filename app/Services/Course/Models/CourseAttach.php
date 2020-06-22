<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseAttach extends Model
{
    use SoftDeletes;

    protected $table = 'course_attach';

    protected $fillable = [
        'course_id', 'name', 'path', 'only_buyer', 'download_times', 'extension',
        'disk', 'size',
    ];
}
