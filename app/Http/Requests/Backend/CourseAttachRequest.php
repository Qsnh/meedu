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
            'name.required' => '请输入附件名',
            'file.required' => '请上传附件',
            'file.mimes' => '格式错误，仅支持：zip,pdf,jpeg,jpg,gif,png,md,doc,txt,csv格式',
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
