<?php

namespace App\Http\Requests\Media\Audio;

use Illuminate\Foundation\Http\FormRequest;

class AudioStoreRequest extends FormRequest
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
            'audio' => ['required', 'file', 'mimes:mp3', 'max:10240']
        ];
    }
}
