<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
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
        $categoriaId = $this->route('categoria');
        
        return [
            'nome' => ['required', 'string', 'min:3', 'max:80', 'unique:categorias,nome,' . $categoriaId],
        ];
    }

    /**
     * Mensagens customizadas de validação
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da categoria é obrigatório.',
            'nome.min' => 'O nome da categoria deve ter no mínimo :min caracteres.',
            'nome.max' => 'O nome da categoria deve ter no máximo :max caracteres.',
            'nome.unique' => 'Já existe uma categoria com este nome.',
        ];
    }
}
