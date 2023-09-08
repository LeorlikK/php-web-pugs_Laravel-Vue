<?php

namespace App\Http\Requests\Media\Photo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhotoStoreRequest extends FormRequest
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
            'name' => ['string', 'max:255'],
            'file' => ['required', 'file', 'mimes:png,jpeg,jpg,gif', 'max:10240',
                Rule::dimensions()->minWidth(100)->minHeight(100)->maxWidth(5000)->maxHeight(5000)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Поле name должно быть строкой',
            'name.max' => 'Поле name не должно превышать 255 символов',
            'file.mimes' => 'Файл не является одним из допустимых форматов(png,jpeg,jpg,gif)',
            'file.max' => 'Максимальный размер файла 10МБ',
            'file.dimensions' => 'Некорректный размер изображения: мин 100х100; макс: 5000х5000'
        ];
    }
}
