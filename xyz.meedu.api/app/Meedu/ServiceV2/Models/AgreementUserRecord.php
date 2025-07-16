<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Services\Member\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgreementUserRecord extends Model
{
    use HasFactory;

    protected $table = 'agreement_user_records';

    protected $fillable = [
        'user_id', 'agreement_id', 'agreement_type', 'agreement_version',
        'agreed_at', 'ip', 'user_agent', 'platform'
    ];

    protected $casts = [
        'agreed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
}
