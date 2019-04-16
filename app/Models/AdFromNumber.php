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
 * App\Models\AdFromNumber.
 *
 * @property int                             $id
 * @property int                             $from_id
 * @property string                          $day
 * @property int                             $num
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\AdFrom              $adFrom
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFromNumber whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
