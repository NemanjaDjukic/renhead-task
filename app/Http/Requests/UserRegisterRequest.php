<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserRegisterRequest extends FormRequest
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
            'first_name' => [
                'required',
                'string',
            ],
            'last_name' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:6',
            ],
            'type' => [
                'required',
                'in:BUYER,APPROVER',
            ],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();
        $validated['password'] = Hash::make($this->password);

        return $validated;
    }
}
