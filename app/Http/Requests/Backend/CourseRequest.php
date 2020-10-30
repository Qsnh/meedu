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
use App\Services\Course\Models\Course;

class CourseRequest extends BaseRequest
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
            'title' => 'required|max:120',
            'thumb' => 'required',
            'short_description' => 'required',
            'original_desc' => 'required',
            'published_at' => 'required',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入课程标题',
            'title.max' => '课程标题的长度不能超过120个字符',
            'thumb.required' => '请上传课程封面',
            'short_description.required' => '请输入课程的简短介绍',
            'original_desc.required' => '请输入课程详情介绍',
            'published_at' => '请输入课程发布时间',
        ];
    }

    public function filldata()
    {
        $data = [
            'user_id' => $this->input('user_id', 0),
            'category_id' => $this->input('category_id'),
            'title' => $this->input('title'),
            'slug' => $this->input('slug'),
            'thumb' => $this->input('thumb'),
            'charge' => $this->input('charge', 0),
            'short_description' => $this->input('short_description'),
            'original_desc' => $this->input('original_desc'),
            'render_desc' => $this->input('render_desc'),
            'seo_keywords' => (string)$this->input('seo_keywords', ''),
            'seo_description' => (string)$this->input('seo_description', ''),
            'published_at' => $this->input('published_at'),
            'is_show' => (int)$this->input('is_show', Course::SHOW_NO),
            'is_rec' => (int)$this->input('is_rec', Course::REC_NO),
            'comment_status' => (int)$this->input('comment_status', Course::COMMENT_STATUS_CLOSE),
        ];

        if ($this->isMethod('post') && !$data['slug']) {
            $slug = implode('-', (new Pinyin())->convert($this->input('title')));
            $data['slug'] = $slug;
        }

        return $data;
    }
}
