<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                      => 'required|regex:/^[a-zA-Z]+$|',
            'last_name'                 => 'required|regex:/^[a-zA-Z]+$|',
            'email'                     => 'required|email:rfc,dns|unique',
            'phone'                     => 'required|regex:[\+]\d{3}\d{9}|unique|numeric',
            'password'                  => 'required',
            'password_confirm'          => 'required',
        ];
    }

    public function messages()
    {
        return [
                    'name.required'             => 'Field Name is required',
            'name.regex'                        => 'Field Name must contain only letters',
            'last_name.required'                => 'Field Last Name is required',
            'last_name.regex'                   => 'Field Last Name must contain only letters',
            'email.required'                    => 'Field Email is required',
            'email.regex'                       => 'Please enter a valid email address',
            'phone.required'                    => 'Field Phone is required',
            'password.required'                 => 'Field Password is required',
            'password_confirm.required'         => 'Field Confirm Password is required',

         ];
    }
}
