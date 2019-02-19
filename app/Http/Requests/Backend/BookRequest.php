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

use Overtrue\Pinyin\Pinyin;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required',
            'thumb' => 'required',
            'charge' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'seo_keywords' => 'required',
            'seo_description' => 'required',
            'published_at' => 'required',
            'is_show' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入书名',
            'thumb.required' => '请上传封面',
            'charge.required' => '请输入价格',
            'short_description.required' => '请输入剪短介绍',
            'description.required' => '请输入详细介绍',
            'seo_keywords.required' => '请输入SEO关键字',
            'seo_description.required' => '请输入SEO描述',
            'published_at.required' => '请选择上线日期',
            'is_show.required' => '请选择是否显示',
        ];
    }

    public function filldata()
    {
        $title = $this->post('title');
        $slug = implode('-', (new Pinyin())->convert($title));

        return [
            'user_id' => 0,
            'title' => $title,
            'slug' => $slug,
            'thumb' => $this->post('thumb'),
            'charge' => $this->post('charge'),
            'short_description' => $this->post('short_description'),
            'description' => $this->post('description'),
            'seo_keywords' => $this->post('seo_keywords'),
            'seo_description' => $this->post('seo_description'),
            'published_at' => $this->post('published_at'),
            'is_show' => $this->post('is_show'),
        ];
    }
}
