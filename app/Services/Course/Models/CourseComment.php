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

use Illuminate\Database\Eloquent\SoftDeletes;

class CourseComment extends Base
{
    use SoftDeletes;

    protected $table = 'course_comments';

    protected $fillable = [
        'user_id', 'course_id', 'original_content', 'render_content',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
