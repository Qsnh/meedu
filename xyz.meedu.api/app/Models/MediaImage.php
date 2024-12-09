<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;

class MediaImage extends Model
{
    protected $table = TableConstant::MEDIA_IMAGES;

    protected $fillable = [
        'url', 'path', 'disk', 'name', 'is_hide', 'scene', 'operator_id', 'operator',

        // 待启用字段
        'category_id',

        // 废弃字段
        'from',
    ];
}
