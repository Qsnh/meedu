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

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $fillable = [
        'admin_id', 'announcement',
    ];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'admin_id');
    }

    /**
     * @param $text
     *
     * @return string
     */
    public function getAnnouncementContent()
    {
        return markdown_to_html($this->announcement);
    }

    /**
     * @return Announcement|null
     */
    public static function recentAnnouncement()
    {
        if (config('meedu.system.cache.status')) {
            return Cache::remember('recent_announcement', 360, function () {
                return self::orderByDesc('updated_at')->limit(1)->first();
            });
        }

        return self::orderByDesc('updated_at')->limit(1)->first();
    }

    public function getEditUrlAttribute()
    {
        return route('backend.announcement.edit', $this);
    }

    public function getDestroyUrlAttribute()
    {
        return route('backend.announcement.destroy', $this);
    }
}
