<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class AdFromRequest extends BaseRequest
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
            'from_name' => 'required',
            'from_key' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'from_name.required' => __('请输入推广链接名'),
            'from_key.required' => __('请输入推广链接特征值'),
        ];
    }

    public function filldata()
    {
        return [
            'from_name' => $this->input('from_name'),
            'from_key' => $this->input('from_key'),
        ];
    }
}
