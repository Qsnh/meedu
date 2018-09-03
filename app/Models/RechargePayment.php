<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RechargePayment extends Model
{

    const STATUS_NO_PAY = 1;
    const STATUS_PAYED = 9;

    protected $table = 'recharge_payments';

    protected $fillable = [
        'user_id', 'money', 'status', 'pay_method',
        'third_id',
    ];

    public function getGoodsTitle()
    {
        return '增加余额';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
