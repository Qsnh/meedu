<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Frontend;

use App\Exceptions\ServiceException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

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

    /**
     * @param Validator $validator
     * @throws ServiceException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ServiceException(implode(',', $validator->errors()->all()));
    }
}
