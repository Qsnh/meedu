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
 * App\Models\Addons.
 *
 * @property int                                                                  $id
 * @property string                                                               $name
 * @property string                                                               $sign               sign标识符
 * @property string                                                               $thumb
 * @property string                                                               $current_version_id
 * @property string                                                               $prev_version_id
 * @property string                                                               $author
 * @property string                                                               $path
 * @property string                                                               $real_path
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @property string|null                                                          $main_url           创建主链接
 * @property int                                                                  $status             1安装中,5安装失败,9成功,3升级中
 * @property \App\Models\AddonsVersion                                            $currentVersion
 * @property \App\Models\AddonsVersion                                            $prevVersion
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AddonsVersion[] $versions
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereCurrentVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereMainUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons wherePrevVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereRealPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addons whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Addons extends Model
{
    const STATUS_INSTALLING = 1;
    const STATUS_DOWNLOAD_FAIL = 2;
    const STATUS_FAIL = 5;
    const STATUS_SUCCESS = 9;
    const STATUS_UPGRADING = 3;
    const STATUS_DEP_INSTALL_FAIL = 6;

    const STATUS_TEXT = [
        self::STATUS_FAIL => '安装失败',
        self::STATUS_SUCCESS => '安装成功',
        self::STATUS_INSTALLING => '初始化',
        self::STATUS_UPGRADING => '升级中',
        self::STATUS_DOWNLOAD_FAIL => '下载失败',
        self::STATUS_DEP_INSTALL_FAIL => '依赖安装失败',
    ];

    protected $table = 'addons';

    protected $fillable = [
        'name', 'sign', 'current_version_id', 'prev_version_id', 'author',
        'path', 'real_path', 'thumb', 'main_url', 'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions()
    {
        return $this->hasMany(AddonsVersion::class, 'addons_id');
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

    /**
     * 状态文本.
     *
     * @return mixed|string
     */
    public function getStatusText()
    {
        return self::STATUS_TEXT[$this->status] ?? '';
    }
}
