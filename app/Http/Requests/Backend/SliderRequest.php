<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort' => 'required',
            'thumb' => 'required',
            'url' => 'required',
            'platform' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'sort.required' => '请输入排序数值',
            'thumb.required' => '请上传图片',
            'url.required' => '请输入链接地址',
            'platform.required' => '请选择平台',
        ];
    }

    public function filldata()
    {
        return [
            'sort' => $this->input('sort'),
            'thumb' => $this->input('thumb'),
            'url' => $this->input('url'),
            'platform' => $this->input('platform'),
        ];
    }
}
