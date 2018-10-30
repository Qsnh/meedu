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

class BookChapterRequest extends FormRequest
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
            'book_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'published_at' => 'required',
            'is_show' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'book_id.required' => '请选择对应的书籍',
            'title.required' => '请输入标题',
            'content.required' => '请输入内容',
            'published_at.required' => '请选择上线时间',
            'is_show.required' => '请选择是否显示',
        ];
    }

    public function filldata()
    {
        return [
            'book_id' => $this->post('book_id'),
            'user_id' => 0,
            'title' => $this->post('title'),
            'content' => $this->post('content'),
            'view_num' => $this->post('view_num', 0),
            'published_at' => $this->post('published_at'),
            'is_show' => $this->post('is_show'),
        ];
    }
}
