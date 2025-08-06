<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\ApiV2;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mobile' => 'required',
            'mobile_code' => 'required',
            'password' => 'required|min:6|max:16',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __('mobile.required'),
            'mobile_code.required' => __('mobile_code.required'),
            'password.required' => __('password.required'),
            'password.min' => __('password.min'),
            'password.max' => __('password.max'),
        ];
    }
}