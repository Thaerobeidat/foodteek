<?php
// app/Http/Requests/RegisterRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users,email',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
