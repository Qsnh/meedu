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

    /**
     * @return string
     */
    public function getGoodsTitle()
    {
        return '增加余额';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 作用域：充值成功
     * @param $query
     * @return mixed
     */
    public function scopeSuccess($query)
    {
        return $query->where('status', self::STATUS_PAYED);
    }

    /**
     * 作用域：用户关键词过滤
     * @param $query
     * @param $keywords
     * @return mixed
     */
    public function scopeUserLike($query, $keywords)
    {
        $userIds = User::where('nick_name', 'like', "%{$keywords}%")
            ->orWhere('mobile', 'like', "%{$keywords}%")
            ->select('id')
            ->pluck('id');
        return $query->orWhereIn('user_id', $userIds);
    }

}
