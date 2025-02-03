<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePacienteRequest extends FormRequest
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
            'cpf' => ['required', 'string', 'max:20'],
            'celular' => ['required', 'string', 'max:20'],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'nome.string' => 'O nome deve ser uma string',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.string' => 'O CPF deve ser uma string',
            'cpf.max' => 'O CPF deve ter no máximo 14 caracteres',
            'celular.required' => 'O celular é obrigatório',
            'celular.string' => 'O celular deve ser uma string',
            'celular.max' => 'O celular deve ter no máximo 20 caracteres',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
