<?php

namespace App;

use App\Models\AdministratorPermission;
use Illuminate\Database\Eloquent\Model;

class AdministratorMenu extends Model
{

    protected $table = 'administrator_menus';

    protected $fillable = [
        'parent_id', 'name', 'url', 'order', 'permission_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(AdministratorPermission::class, 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

}
