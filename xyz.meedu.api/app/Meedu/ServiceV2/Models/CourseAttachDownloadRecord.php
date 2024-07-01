<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAttachDownloadRecord extends Model
{

    protected $table = 'course_attach_download_records';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'course_id', 'attach_id', 'ip', 'ip_area', 'created_at',
    ];

}
