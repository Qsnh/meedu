<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

use Carbon\Carbon;
use App\Constant\AgreementConstant;

class AgreementRequest extends BaseRequest
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
        $rules = [
            'type' => 'required|in:' . implode(',', array_keys(AgreementConstant::TYPES)),
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'version' => 'required|string|max:50',
            'is_active' => 'required|boolean',
            'effective_at' => $this->getEffectiveAtRule(),
        ];

        return $rules;
    }

    /**
     * 获取生效时间验证规则
     */
    protected function getEffectiveAtRule()
    {
        // 如果选择生效，则生效时间必须填写
        if ($this->input('is_active') == 1) {
            return 'required|date';
        }
        
        return 'nullable|date';
    }

    public function messages()
    {
        return [
            'type.required' => __('请选择协议类型'),
            'type.in' => __('协议类型不正确'),
            'title.required' => __('请输入协议标题'),
            'content.required' => __('请输入协议内容'),
            'version.required' => __('请输入版本号'),
            'is_active.required' => __('请选择是否为生效版本'),
            'effective_at.required' => __('选择生效时必须填写生效时间'),
            'effective_at.date' => __('生效时间格式不正确'),
        ];
    }

    public function filldata()
    {
        $data = [
            'type' => $this->input('type'),
            'title' => $this->input('title'),
            'content' => $this->input('content'),
            'version' => $this->input('version'),
            'is_active' => (int)$this->input('is_active'),
        ];

        // 如果选择生效，设置生效时间
        if ($data['is_active']) {
            $data['effective_at'] = $this->input('effective_at') ? Carbon::parse($this->input('effective_at')) : null;
        } else {
            // 如果取消生效，清空生效时间
            $data['effective_at'] = null;
        }

        return $data;
    }
}
