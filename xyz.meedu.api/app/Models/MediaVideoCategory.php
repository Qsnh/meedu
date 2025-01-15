<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaVideoCategory extends Model
{

    protected $table = 'media_video_categories';

    protected $fillable = [
        'name', 'sort', 'admin_id', 'parent_id', 'parent_chain',
    ];

}
