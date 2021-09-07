<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseComment extends Base
{
    use SoftDeletes,HasFactory;

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
