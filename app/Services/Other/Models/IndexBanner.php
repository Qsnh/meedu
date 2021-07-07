<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
