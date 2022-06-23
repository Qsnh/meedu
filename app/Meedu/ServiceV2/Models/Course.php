<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'user_id', 'title', 'slug', 'thumb', 'charge',
        'short_description', 'original_desc', 'render_desc', 'seo_keywords',
        'seo_description', 'published_at', 'is_show', 'category_id',
        'is_rec', 'user_count', 'is_free',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id');
    }


    public function videos()
    {
        return $this->hasMany(CourseVideo::class, 'course_id', 'id');
    }
}
