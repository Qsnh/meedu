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

/**
 * App\Models\SmsRecord.
 *
 * @property int                             $id
 * @property string                          $mobile        手机号
 * @property string|null                     $send_data     发送数据
 * @property string|null                     $response_data 响应数据
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord whereResponseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord whereSendData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SmsRecord extends Model
{
    protected $table = 'sms_records';

    protected $fillable = [
        'mobile', 'send_data', 'response_data',
    ];

    public static function createData(string $mobile, array $sendData, array $response)
    {
        $self = new self();
        $self->mobile = $mobile;
        $self->send_data = json_encode($sendData);
        $self->response_data = json_encode($response);
        $self->save();
    }
}
