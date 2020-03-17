<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdFrom.
 *
 * @property int $id
 * @property string $from_name
 * @property string $from_key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AdFromNumber[] $numbers
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom whereFromKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom whereFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFrom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        return route('index', ['from_key' => $this->from_key]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function numbers()
    {
        return $this->hasMany(AdFromNumber::class, 'from_id');
    }
}
