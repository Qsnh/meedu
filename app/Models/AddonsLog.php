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

class AddonsLog extends Model
{
    const TYPE_INSTALL = 'INSTALL';
    const TYPE_UPGRADE = 'UPGRADE';
    const TYPE_ROLLBACK = 'ROLLBACK';
    const TYPE_DEPENDENCY = 'DEPENDENCY_INSTALL';
    const TYPE_DOWNLOAD = 'DOWNLOAD';

    protected $table = 'addons_logs';

    protected $fillable = [
        'addons_id', 'version', 'type', 'log',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addons()
    {
        return $this->belongsTo(Addons::class, 'addons_id');
    }
}
