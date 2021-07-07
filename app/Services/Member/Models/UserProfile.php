<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id', 'real_name', 'gender', 'age', 'birthday', 'profession', 'address',
        'graduated_school', 'diploma',
        'id_number', 'id_frontend_thumb', 'id_backend_thumb', 'id_hand_thumb',
    ];

    public const EDIT_COLUMNS = [
        'real_name', 'gender', 'age', 'birthday', 'profession', 'address',
        'graduated_school', 'diploma',
        'id_number', 'id_frontend_thumb', 'id_backend_thumb', 'id_hand_thumb',
    ];
}
