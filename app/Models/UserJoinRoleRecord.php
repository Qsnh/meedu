<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserJoinRoleRecord extends Model
{

    protected $table = 'user_join_role_records';

    protected $fillable = [
        'user_id', 'role_id', 'charge', 'started_at', 'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
