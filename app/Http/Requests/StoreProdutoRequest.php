<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
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
            'nome' => ['required', 'string', 'min:3', 'max:120'],
            'valor' => ['required', 'numeric', 'gt:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantidade' => ['nullable', 'integer', 'min:0'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
        ];
    }

    /**
     * Preparar dados para validação
     */
    protected function prepareForValidation(): void
    {
        if (!$this->has('quantidade')) {
            $this->merge(['quantidade' => 0]);
        }
    }

    /**
     * Mensagens customizadas de validação
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.min' => 'O nome do produto deve ter no mínimo :min caracteres.',
            'nome.max' => 'O nome do produto deve ter no máximo :max caracteres.',
            'valor.required' => 'O valor do produto é obrigatório.',
            'valor.numeric' => 'O valor deve ser um número.',
            'valor.gt' => 'O valor deve ser maior que zero.',
            'valor.regex' => 'O valor deve ter no máximo 2 casas decimais.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade não pode ser negativa.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
        ];
    }
}
