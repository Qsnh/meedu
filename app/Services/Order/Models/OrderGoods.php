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
use App\Services\Order\Models\scopes\UserScope;

class OrderGoods extends Model
{
    const GOODS_TYPE_COURSE = 'COURSE';
    const GOODS_TYPE_VIDEO = 'VIDEO';
    const GOODS_TYPE_ROLE = 'ROLE';
    const GOODS_TYPE_BOOK = 'BOOK';

    protected $table = 'order_goods';

    protected $fillable = [
        'user_id', 'goods_id', 'goods_type', 'order_id',
        'num', 'charge',
    ];

    protected $appends = [
        'goods_text',
    ];

    public function getGoodsTextAttribute()
    {
        return __($this->goods_type);
    }

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
