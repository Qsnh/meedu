<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPaidRecord extends Model
{
    use SoftDeletes;

    const PAID_TYPE_DEFAULT = 0;
    const PAID_TYPE_PROMO_CODE = 1;
    const PAID_TYPE_INVITE_BALANCE = 2;

    const PAID_TYPE_TEXT = [
        self::PAID_TYPE_DEFAULT => '直接支付',
        self::PAID_TYPE_INVITE_BALANCE => '邀请余额支付',
        self::PAID_TYPE_PROMO_CODE => '优惠码支付',
    ];

    protected $table = 'order_paid_records';

    protected $fillable = [
        'user_id', 'order_id', 'paid_total', 'paid_type', 'paid_type_id',
    ];

    protected $appends = [
        'paid_type_text',
    ];

    public function getPaidTypeTextAttribute()
    {
        return self::PAID_TYPE_TEXT[$this->paid_type] ?? '';
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
