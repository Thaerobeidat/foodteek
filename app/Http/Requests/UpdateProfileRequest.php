<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // يمكن تعديلها حسب الحاجة
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users,email,' . $this->user()->id,
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:15',
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
            'name.required' => __('validation.required', ['attribute' => 'الاسم']),
            'email.required' => __('validation.required', ['attribute' => 'البريد الإلكتروني']),
            'email.email' => __('validation.email', ['attribute' => 'البريد الإلكتروني']),
            'email.unique' => __('validation.unique', ['attribute' => 'البريد الإلكتروني']),
            'phone.required' => __('validation.required', ['attribute' => 'رقم الهاتف']),
        ];
    }
}
