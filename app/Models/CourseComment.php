<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CourseComment.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $course_id
 * @property string|null                     $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $deleted_at
 * @property \App\Models\Course              $course
 * @property \App\User                       $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment des()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseComment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CourseComment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseComment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseComment withoutTrashed()
 * @mixin \Eloquent
 */
class CourseComment extends Model
{
    use SoftDeletes;
    use Scope;

    protected $table = 'course_comments';

    protected $fillable = [
        'user_id', 'course_id', 'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getContent()
    {
        return markdown_to_html($this->content);
    }
}
