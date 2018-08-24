<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsRecord extends Model
{

    protected $table = 'sms_records';

    protected $fillable = [
        'mobile', 'send_data', 'response_data',
    ];

    public static function createData(string $mobile, array $sendData, array $response)
    {
        $self = new self;
        $self->mobile = $mobile;
        $self->send_date = $sendData;
        $self->response_data = $response;
        $self->save();
    }

}
