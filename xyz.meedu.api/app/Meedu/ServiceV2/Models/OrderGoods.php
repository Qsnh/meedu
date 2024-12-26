<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{

    protected $table = TableConstant::TABLE_ORDER_GOODS;

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

}
