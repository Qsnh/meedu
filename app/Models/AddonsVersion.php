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
 * App\Models\AddonsVersion.
 *
 * @property int                             $id
 * @property int                             $addons_id
 * @property string                          $version
 * @property string                          $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Addons              $addons
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion whereAddonsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AddonsVersion whereVersion($value)
 * @mixin \Eloquent
 */
class AddonsVersion extends Model
{
    protected $table = 'addons_version';

    protected $fillable = [
        'addons_id', 'version', 'path',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addons()
    {
        return $this->belongsTo(Addons::class, 'addons_id');
    }
}
