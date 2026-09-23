<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class PageStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'url'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string']
        ];
    }
    /**
     * Get custom messages for validator errors.
     * 
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'required' => 'Nenhum campo pode ser vazio',
            'title.string' => 'O titulo deve conter apenas caracteres alfa númericos',
            'title.max' => 'O titulo passou do tamanho máximo permitido',
            'content.string' => 'O corpo enviado não é válido'
        ];
    }
}
