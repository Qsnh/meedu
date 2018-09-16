<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required',
            'charge' => 'required',
            'expire_days' => 'required',
            'weight' => 'required',
            'description' => 'required',
        ];
    }

    public function filldata()
    {
        return [
            'name' => $this->input('name'),
            'charge' => $this->input('charge'),
            'expire_days' => $this->input('expire_days'),
            'weight' => $this->input('weight'),
            'description' => $this->input('description'),
        ];
    }

}
