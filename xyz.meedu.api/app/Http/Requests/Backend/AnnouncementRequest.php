<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;

class AnnouncementRequest extends BaseRequest
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
            'announcement' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('请输入公告标题'),
            'announcement.required' => __('请输入公告内容'),
        ];
    }

    public function filldata()
    {
        return [
            'title' => $this->input('title'),
            'admin_id' => Auth::guard(BackendApiConstant::GUARD)->user()->id,
            'announcement' => clean($this->input('announcement')),
        ];
    }
}
