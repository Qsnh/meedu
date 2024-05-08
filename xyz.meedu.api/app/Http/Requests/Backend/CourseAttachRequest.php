<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class CourseAttachRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'file' => 'required|mimes:zip,pdf,jpeg,jpg,gif,png,md,doc,txt,csv',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('请输入附件名'),
            'file.required' => __('请上传文件'),
            'file.mimes' => __('请上传:format格式文件', ['format' => 'zip,pdf,jpeg,jpg,gif,png,md,doc,txt,csv']),
        ];
    }

    public function filldata()
    {
        $data = [
            'course_id' => $this->input('course_id'),
            'name' => $this->input('name'),
            'only_buyer' => $this->input('only_buyer', 1),
        ];

        $path = $this->input('path');
        if ($this->hasFile('file')) {
            $file = $this->file('file');
            $size = $file->getSize();
            $path = $this->file('file')->store(config('meedu.upload.attach.course.path'), ['disk' => config('meedu.upload.attach.course.disk')]);
            $data['extension'] = $file->getClientOriginalExtension();
            $data['size'] = $size;
            $data['disk'] = config('meedu.upload.attach.course.disk');
        }

        $data['path'] = $path;

        return $data;
    }
}
