<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class SearchRecord extends Model
{
    use Searchable;

    protected $table = 'search_records';

    protected $fillable = [
        'resource_type', 'resource_id', 'title', 'charge', 'thumb', 'short_desc',
        'desc',
    ];
}
