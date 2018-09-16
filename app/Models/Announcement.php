<?php

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
     * @return string
     */
    public function getAnnouncementContent()
    {
        return (new \Parsedown)->text($this->announcement);
    }

    /**
     * @return Announcement|null
     */
    public static function recentAnnouncement()
    {
        return Cache::remember('recent_announcement', 360, function () {
            return self::orderByDesc('updated_at')->limit(1)->first();
        });
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
