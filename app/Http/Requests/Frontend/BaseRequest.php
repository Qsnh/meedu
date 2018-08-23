<?php

namespace App\Http\Requests\Frontend;

use App\Exceptions\MeeduErrorResponseJsonException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
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

    // JSON下自定义数据返回格式
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new MeeduErrorResponseJsonException($validator->errors()->all()[0]);
        } else {
            parent::failedValidation($validator);
        }
    }

}
