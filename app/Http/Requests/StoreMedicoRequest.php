<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMedicoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'especialidade' => ['required', 'string', 'max:255'],
            'cidade_id' => ['required', 'integer', 'exists:cidades,id'],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'nome.string' => 'O nome deve ser uma string',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            'especialidade.required' => 'A especialidade é obrigatória',
            'especialidade.string' => 'A especialidade deve ser uma string',
            'especialidade.max' => 'A especialidade deve ter no máximo 255 caracteres',
            'cidade_id.required' => 'A cidade é obrigatória',
            'cidade_id.integer' => 'A cidade deve ser um número inteiro',
            'cidade_id.exists' => 'A cidade informada não existe',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
