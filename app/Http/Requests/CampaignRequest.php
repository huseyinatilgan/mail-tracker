<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampaignRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'regex:/^[\p{L}\p{N}\s\-_\.]+$/u', // Sadece harf, rakam, boşluk, tire, alt çizgi ve nokta
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Input'u trim et ve sanitize et
        if ($this->has('name')) {
            $this->merge([
                'name' => trim(strip_tags($this->name)),
            ]);
        }
    }

    /**
     * Validation mesajları
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Kampanya adı zorunludur.',
            'name.string' => 'Kampanya adı metin olmalıdır.',
            'name.max' => 'Kampanya adı en fazla 255 karakter olabilir.',
            'name.min' => 'Kampanya adı en az 3 karakter olmalıdır.',
            'name.regex' => 'Kampanya adı sadece harf, rakam, boşluk, tire, alt çizgi ve nokta içerebilir.',
        ];
    }
}
