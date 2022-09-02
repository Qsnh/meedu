<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;

class UserUploadImage extends Model
{
    protected $table = TableConstant::TABLE_USER_UPLOAD_IMAGES;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'group', 'disk', 'path', 'name', 'visit_url', 'log_api', 'log_ip', 'log_ua',
        'created_at',
    ];
}
