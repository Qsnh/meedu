<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaImage extends Model
{
    protected $table = 'media_images';

    protected $fillable = [
        'from', 'url', 'path', 'disk', 'name',
    ];
}
