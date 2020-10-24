<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\ApiV2;

class SmsRequest extends BaseRequest
{
    public function rules()
    {
        $scenes = [
            'register', 'login', 'password_reset', 'mobile_bind',
        ];
        return [
            'mobile' => 'required',
            'image_captcha' => 'required',
            'image_key' => 'required',
            'scene' => 'in:' . implode(',', $scenes),
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __('mobile.required'),
            'image_captcha.required' => __('image_captcha.required'),
            'image_key.required' => __('image_key.required'),
            'scene.in' => __('sms_scene_error'),
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->post('mobile'),
            'scene' => $this->post('scene'),
        ];
    }
}
