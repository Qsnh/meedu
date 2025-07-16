<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agreement extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'agreements';

    protected $fillable = [
        'type', 'title', 'content', 'version', 'is_active', 'effective_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'effective_at' => 'datetime',
    ];

    public function userRecords()
    {
        return $this->hasMany(AgreementUserRecord::class, 'agreement_id');
    }
}
