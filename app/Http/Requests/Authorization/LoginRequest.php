<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:3']
        ];
    }

    public function messages():array
    {
        return [
            'email.required' => 'Введите email!',
            'email.email' => 'Некорректный email!',
            'exists' => 'Такого пользователя не существует!',
            'password.required' => 'Введите пароль!',
            'password.string' => 'Некорректный пароль!',
        ];
    }
}
