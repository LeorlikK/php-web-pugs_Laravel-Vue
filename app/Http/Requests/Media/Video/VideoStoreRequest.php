<?php

namespace App\Http\Requests\Media\Video;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoStoreRequest extends FormRequest
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
            'video' => ['required', 'file', 'mimes:mp4', 'max:104857600']
        ];
    }

    public function messages(): array
    {
        return [
            'video.mimes' => 'Файл не является одним из допустимых форматов(mp4)',
            'video.max' => 'Максимальный размер файла 10МБ',
        ];
    }
}
