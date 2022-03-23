<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class TravelPaymentRequest extends FormRequest
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
            'amount' => [
                'required',
                'numeric',
                'min:1',
            ]
        ];
    }

    protected function prepareForValidation()
    {
        if (auth()->user()->type !== 'BUYER') {
            throw ValidationException::withMessages([
                'user' => "You don't have permission to buy."
            ]);
        }
    }
}
