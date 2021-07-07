<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;

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
