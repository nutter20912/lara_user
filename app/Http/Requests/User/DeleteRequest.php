<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\ApiValidationException;

class DeleteRequest extends FormRequest
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
            'account' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
            'account.required' => '帳號必填',
            'account.max' => '帳號超過範圍',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new ApiValidationException($validator->errors()->first(), 6);
    }
}
