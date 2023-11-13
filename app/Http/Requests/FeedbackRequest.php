<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
            'feedback' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'feedback.required' => 'Напишите что-нибудь',
            'feedback.string' => 'В сообщении присутствуют инородные символы',
        ];
    }
}
