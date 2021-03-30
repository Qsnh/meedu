<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;

class AdFromNumber extends Model
{
    protected $table = 'ad_from_number';

    protected $fillable = [
        'from_id', 'day', 'num',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adFrom()
    {
        return $this->belongsTo(AdFrom::class, 'from_id');
    }
}
