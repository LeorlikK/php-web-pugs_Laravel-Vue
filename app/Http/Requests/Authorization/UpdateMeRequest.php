<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMeRequest extends FormRequest
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
            'login' => ['nullable', 'string', 'max:20', 'min:3', Rule::unique('users', 'login')->ignore(auth()->user()->id)],
            'avatar' => ['nullable', 'mimes:png,jpeg,jpg,gif', 'max:10240',
                Rule::dimensions()->minWidth(100)->minHeight(100)->maxWidth(5000)->maxHeight(5000)]
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Поле login обязательно для заполнения!',
            'login.string' => 'Поле login должно быть строкой!',
            'login.min' => 'Поле login должно быть больше 3 символов!',
            'login.max' => 'Поле login не должно превышать 20 символов!',
            'login.unique' => 'Такой пользователь уже существует!',
            'avatar.mimes' => 'Файл должен быть изображением!',
            'avatar.max' => 'Максимальный размер файла 10МБ!',
            'avatar.dimensions' => 'Некорректный размер изображения: мин 100х100; макс: 5000х5000',
        ];
    }
}
