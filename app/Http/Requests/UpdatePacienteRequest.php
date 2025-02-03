<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePacienteRequest extends FormRequest
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
            'id' => ['required', 'integer', 'exists:pacientes'],
            'nome' => ['required', 'string', 'max:255'],
            'celular' => ['required', 'string', 'max:20'],
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'O id é obrigatório',
            'id.integer' => 'O id deve ser um número inteiro',
            'id.exists' => 'O id informado não existe',
            'nome.required' => 'O nome é obrigatório',
            'nome.string' => 'O nome deve ser uma string',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            'celular.required' => 'O celular é obrigatório',
            'celular.string' => 'O celular deve ser uma string',
            'celular.max' => 'O celular deve ter no máximo 20 caracteres',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
