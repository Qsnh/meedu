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

class AdFrom extends Model
{
    protected $table = 'ad_from';

    protected $fillable = [
        'from_name', 'from_key',
    ];

    protected $appends = [
        'url'
    ];

    public function getUrlAttribute()
    {
        return url('/') . '?from_key=' . $this->from_key;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function numbers()
    {
        return $this->hasMany(AdFromNumber::class, 'from_id');
    }
}
