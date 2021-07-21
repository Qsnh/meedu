<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaVideo extends Model
{
    protected $table = 'media_videos';

    protected $fillable = [
        'title', 'thumb', 'duration', 'size', 'storage_driver', 'storage_file_id',
        'transcode_status', 'ref_count',
    ];

    protected $appends = [
        'size_mb'
    ];

    public function getSizeMbAttribute()
    {
        return round($this->size / 1024 / 1024, 2);
    }
}
