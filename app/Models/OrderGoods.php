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
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderGoods.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property string                          $order_id   订单编号
 * @property int                             $goods_id   商品ID
 * @property string                          $goods_type 商品类型标识符
 * @property int                             $num        商品数量
 * @property int                             $charge     商品价格
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed                           $goods_name
 * @property \App\Models\Order               $order
 * @property \App\User                       $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereGoodsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereGoodsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderGoods whereUserId($value)
 * @mixin \Eloquent
 */
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
        'goods_name',
    ];

    public function getGoodsNameAttribute()
    {
        return $this->getGoodsTypeText();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 获取当前订单的商品名.
     *
     * @return mixed
     */
    public function getGoodsTypeText(): string
    {
        $method = 'get'.ucfirst(strtolower($this->goods_type)).'GoodsTypeText';

        return $this->{$method}();
    }

    protected function getCourseGoodsTypeText(): string
    {
        $course = Course::find($this->goods_id);

        return "课程《{$course->title}》";
    }

    protected function getVideoGoodsTypeText(): string
    {
        $video = Video::find($this->goods_id);

        return "视频《{$video->title}》";
    }

    protected function getRoleGoodsTypeText(): string
    {
        $role = Role::find($this->goods_id);

        return "VIP《{$role->name}》";
    }

    protected function getBookGoodsTypeText(): string
    {
        $book = Book::find($this->goods_id);

        return "电子书《{$book->title}》";
    }
}
