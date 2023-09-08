<?php

namespace App\Http\Requests\Media\Photo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhotoUpdateRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Поле name должно быть строкой',
            'name.max' => 'Поле name не должно превышать 255 символов',
        ];
    }
}
