<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;

class UserFaceVerifyTencentRecord extends Model
{
    protected $table = 'user_face_verify_tencent_records';

    protected $fillable = [
        'user_id', 'request_id', 'rule_id', 'url', 'biz_token',
        'status', 'verify_image_url', 'verify_video_url',
    ];
}
