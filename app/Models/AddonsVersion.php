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
