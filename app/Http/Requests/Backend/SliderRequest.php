<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Backend;

class SliderRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'thumb' => 'required',
            'url' => 'required',
            'platform' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'thumb.required' => __('请上传图片'),
            'url.required' => __('请输入链接地址'),
            'platform.required' => __('请选择平台'),
        ];
    }

    public function filldata()
    {
        return [
            'sort' => (int)$this->input('sort'),
            'thumb' => $this->input('thumb'),
            'url' => $this->input('url'),
            'platform' => $this->input('platform'),
        ];
    }
}
