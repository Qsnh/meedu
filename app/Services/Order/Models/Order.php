<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Order\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Base\Services\ConfigService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public const STATUS_UNPAY = 1;
    public const STATUS_PAYING = 5;
    public const STATUS_PAID = 9;
    public const STATUS_CANCELED = 7;

    public const STATUS_TEXT = [
        self::STATUS_UNPAY => '未支付',
        self::STATUS_PAYING => '支付中',
        self::STATUS_PAID => '已支付',
        self::STATUS_CANCELED => '已取消',
    ];

    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'charge', 'status', 'order_id', 'payment',
        'payment_method', 'is_refund', 'last_refund_at',
    ];

    protected $appends = [
        'status_text', 'payment_text', 'continue_pay',
    ];

    public function getStatusTextAttribute()
    {
        return $this->statusText();
    }

    public function getPaymentTextAttribute()
    {
        return $this->getPaymentText();
    }

    public function getContinuePayAttribute()
    {
        return in_array($this->status, [self::STATUS_UNPAY, self::STATUS_PAYING]);
    }

    public function goods()
    {
        return $this->hasMany(OrderGoods::class, 'oid');
    }

    public function statusText(): string
    {
        return self::STATUS_TEXT[$this->status] ?? '';
    }

    public function scopeStatus($query, $status)
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function getPaymentText()
    {
        /**
         * @var ConfigService
         */
        $configService = app()->make(ConfigService::class);
        $payments = collect($configService->getPayments());

        return $payments[$this->payment]['name'] ?? '';
    }

    public function paidRecords()
    {
        return $this->hasMany(OrderPaidRecord::class, 'order_id');
    }

    public function refund()
    {
        return $this->hasMany(OrderRefund::class, 'order_id');
    }
}
