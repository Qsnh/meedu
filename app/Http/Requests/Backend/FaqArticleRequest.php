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

use Illuminate\Foundation\Http\FormRequest;

class FaqArticleRequest extends FormRequest
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
            'category_id' => 'required',
            'title' => 'required|max:255',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => '请选择分类',
            'title.required' => '请输入标题',
            'title.max' => '标题不能超过255个字',
            'content.required' => '请输入内容',
        ];
    }

    /**
     * @return array
     */
    public function filldata(): array
    {
        return [
            'admin_id' => admin()->id,
            'category_id' => $this->input('category_id'),
            'title' => $this->input('title'),
            'content' => $this->input('content'),
        ];
    }
}
