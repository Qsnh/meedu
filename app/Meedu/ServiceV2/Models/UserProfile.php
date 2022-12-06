<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $table = TableConstant::TABLE_USER_PROFILES;

    protected $fillable = [
        'user_id',
        'real_name',//真实姓名
        'gender',//性别
        'age',//年龄
        'birthday',//生日
        'profession', //职业
        'address',//住址
        'graduated_school',//毕业院校
        'diploma',//毕业证照片
        'id_number',//身份证号
        'id_frontend_thumb',//身份证人像面
        'id_backend_thumb',//身份证国徽面
        'id_hand_thumb',//手持身份证照
        'is_verify',//是否实名认证
    ];

    public const EDIT_COLUMNS = [
        'real_name', 'gender', 'age', 'birthday', 'profession', 'address',
        'graduated_school', 'diploma',
        'id_number', 'id_frontend_thumb', 'id_backend_thumb', 'id_hand_thumb',
    ];
}
