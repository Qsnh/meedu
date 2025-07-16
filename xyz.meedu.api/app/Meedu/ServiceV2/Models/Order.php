<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = TableConstant::TABLE_ORDERS;

    protected $fillable = [
        'user_id', 'charge', 'status', 'order_id', 'payment',
        'payment_method', 'is_refund', 'last_refund_at',
        'agreement_id',
    ];
}
