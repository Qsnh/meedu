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

use Illuminate\Database\Eloquent\Model;

class OrderRemoteRelation extends Model
{
    const PAYMENT_YOUZAN = 'youzan';

    protected $table = 'order_remote_relation';

    protected $fillable = [
        'order_id', 'remote_id', 'payment', 'create_data',
        'callback_data',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
