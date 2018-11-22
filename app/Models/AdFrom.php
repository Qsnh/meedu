<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdFrom extends Model
{

    protected $table = 'ad_from';

    protected $fillable = [
        'from_name', 'from_key',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function numbers()
    {
        return $this->hasMany(AdFromNumber::class, 'from_id');
    }

}
