<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;

class IndexBanner extends Model
{
    protected $table = 'index_banners';

    protected $fillable = [
        'name', 'sort', 'course_ids',
    ];
}
