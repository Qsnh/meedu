<?php

namespace App\Http\Requests\Backend;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Overtrue\Pinyin\Pinyin;

class CourseRequest extends FormRequest
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
            'description' => 'required',
            'published_at' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入课程标题',
            'title.max' => '课程标题的长度不能超过120个字符',
            'thumb.required' => '请上传课程封面',
            'short_description.required' => '请输入课程的简短介绍',
            'description.required' => '请输入课程详情介绍',
            'published_at' => '请输入课程发布时间',
        ];
    }

    public function filldata()
    {
        $data = [
            'user_id' => $this->input('user_id', 0),
            'title' => $this->input('title'),
            'thumb' => $this->input('thumb'),
            'charge' => $this->input('charge', 0),
            'short_description' => $this->input('short_description'),
            'description' => $this->input('description'),
            'seo_keywords' => $this->input('seo_keywords', ''),
            'seo_description' => $this->input('seo_description', ''),
            'published_at' => $this->input('published_at'),
            'is_show' => $this->input('is_show', Course::SHOW_NO),
        ];

        if ($this->isMethod('post')) {
            $slug = implode('-', (new Pinyin())->convert($this->input('title')));
            $data['slug'] = $slug;
        }

        return $data;
    }

}
