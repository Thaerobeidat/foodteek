<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Get custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => __('validation.required', ['attribute' => 'البريد الإلكتروني']),
            'email.email' => __('validation.email', ['attribute' => 'البريد الإلكتروني']),
            'email.exists' => __('validation.exists', ['attribute' => 'البريد الإلكتروني']),
            'password.required' => __('validation.required', ['attribute' => 'كلمة المرور']),
            'password.min' => __('validation.min.string', ['attribute' => 'كلمة المرور', 'min' => 8]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => 'كلمة المرور']),
        ];
    }
}
