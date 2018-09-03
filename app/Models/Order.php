<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    const GOODS_TYPE_COURSE = 'COURSE';
    const GOODS_TYPE_VIDEO = 'VIDEO';
    const GOODS_TYPE_ROLE = 'ROLE';

    const STATUS_UNPAY = 1;
    const STATUS_PAID = 9;

    protected $table = 'orders';

    public $fillable = [
        'user_id', 'goods_id', 'goods_type',
        'charge', 'status', 'extra',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
