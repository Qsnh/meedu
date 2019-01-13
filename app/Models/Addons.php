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

class Addons extends Model
{
    const STATUS_INSTALLING = 1;
    const STATUS_FAIL = 5;
    const STATUS_SUCCESS = 9;
    const STATUS_UPGRADING = 3;

    protected $table = 'addons';

    protected $fillable = [
        'name', 'current_version_id', 'prev_version_id', 'author',
        'path', 'real_path', 'thumb', 'main_url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions()
    {
        return $this->hasMany(AddonsVersion::class, 'addons_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(AddonsLog::class, 'addons_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentVersion()
    {
        return $this->belongsTo(AddonsVersion::class, 'current_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prevVersion()
    {
        return $this->belongsTo(AddonsVersion::class, 'prev_version_id');
    }
}
