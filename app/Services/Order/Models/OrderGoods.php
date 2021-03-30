<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Order\Models;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    const GOODS_TYPE_COURSE = 'COURSE';
    const GOODS_TYPE_VIDEO = 'VIDEO';
    const GOODS_TYPE_ROLE = 'ROLE';

    protected $table = 'order_goods';

    protected $fillable = [
        // 订单表orders的id
        'oid',
        // 商品信息
        'goods_id', 'goods_type', 'goods_name', 'goods_thumb', 'goods_charge', 'goods_ori_charge',
        // 购买数量和价格
        'num', 'charge',
        'user_id',
        // todo 即将废弃
        'order_id',
    ];

    protected $appends = [
        'goods_text',
    ];

    public function getGoodsTextAttribute()
    {
        return __($this->goods_type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'oid');
    }
}
