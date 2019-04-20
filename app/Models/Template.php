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
 * App\Models\Template.
 *
 * @property int                             $id
 * @property string                          $name
 * @property string                          $current_version
 * @property string                          $path
 * @property string                          $real_path
 * @property string                          $author
 * @property string                          $thumb
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereCurrentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereRealPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Template extends Model
{
    protected $table = 'templates';

    protected $fillable = [
        'name', 'current_version', 'path', 'real_path',
        'author', 'thumb',
    ];
}
