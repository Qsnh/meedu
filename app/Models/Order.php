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

class Order extends Model
{
    const GOODS_TYPE_COURSE = 'COURSE';
    const GOODS_TYPE_VIDEO = 'VIDEO';
    const GOODS_TYPE_ROLE = 'ROLE';

    const STATUS_UNPAY = 1;
    const STATUS_PAID = 9;

    protected $table = 'orders';

    public $fillable = [
        'user_id', 'goods_id', 'goods_type',
        'charge', 'status', 'extra',
    ];

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
    public function getGoodsTypeText()
    {
        $method = 'get'.ucfirst(strtolower($this->goods_type)).'GoodsTypeText';

        return $this->{$method}();
    }

    /**
     * 获取订单的消息通知内容.
     *
     * @return string
     */
    public function getNotificationContent()
    {
        return '你已经购买了'.$this->getGoodsTypeText().'，花费了'.$this->charge.'元';
    }

    protected function getCourseGoodsTypeText()
    {
        $course = Course::find($this->goods_id);

        return "课程《{$course->title}》";
    }

    protected function getVideoGoodsTypeText()
    {
        $video = Video::find($this->goods_id);

        return "视频《{$video->title}》";
    }

    protected function getRoleGoodsTypeText()
    {
        $role = Role::find($this->goods_id);

        return "VIP《{$role->name}》";
    }
}
