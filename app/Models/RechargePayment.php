<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use App\User;
use Illuminate\Http\Request;
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
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeSuccess($query)
    {
        return $query->where('status', self::STATUS_PAYED);
    }

    /**
     * 作用域：用户关键词过滤.
     *
     * @param $query
     * @param $keywords
     *
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

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public static function filter(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $status = $request->input('status', '');
        $query = RechargePayment::with(['user'])
            ->when($status, function ($query) use ($status) {
                return $query->whereStatus($status);
            })->when($keywords, function ($query) use ($keywords) {
                return $query->userLike($keywords)
                    ->orWhere('third_id', 'like', "%{$keywords}%")
                    ->orWhere('pay_method', $keywords);
            })
            ->orderByDesc('created_at');

        return $query;
    }

    /**
     * @return string
     */
    public function statusText()
    {
        return $this->status == self::STATUS_NO_PAY ? '已支付' : '未支付';
    }
}
