<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdFrom extends Model
{
    use HasFactory;

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
