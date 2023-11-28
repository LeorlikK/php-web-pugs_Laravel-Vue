<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsStoreRequest extends FormRequest
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
            'image' => ['file', 'mimes:png,jpeg,jpg,gif', 'max:10240',
                Rule::dimensions()->minWidth(100)->minHeight(100)->maxWidth(5000)->maxHeight(5000)],
            'title' => ['required', 'string', 'max:250'],
            'short' => ['required', 'string', 'max:500'],
            'text' => ['required','string', 'max:5000'],
            'publish' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'image.mimes' => 'Файл не является одним из допустимых форматов(png,jpeg,jpg,gif)',
            'image.max' => 'Максимальный размер файла 10МБ',
            'image.dimensions' => 'Некорректный размер изображения: мин 100х100; макс: 5000х5000',
            'title.max' => 'Поле title не должно превышать 255 символов',
            'title.required' => 'Поле title обязательно для заполнения',
            'title.string' => 'В тексте присутствуют инородные символы',
            'short.max' => 'Поле short не должно превышать 500 символов',
            'short.required' => 'Поле short обязательно для заполнения',
            'short.string' => 'В тексте присутствуют инородные символы',
            'text.max' => 'Поле text не должно превышать 5000 символов',
            'text.required' => 'Поле text обязательно для заполнения',
            'text.string' => 'В тексте присутствуют инородные символы',
        ];
    }
}
