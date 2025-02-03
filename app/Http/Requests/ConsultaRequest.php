<?php

namespace App\Http\Requests;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ConsultaRequest extends FormRequest
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
            'medico_id' => ['required', 'exists:medicos,id'],
            'paciente_id' => ['required', 'exists:pacientes,id'],
            'data' => ['required', Rule::date()->format('Y-m-d H:i:s'),],
        ];
    }

    public function messages()
    {
        return [
            'medico_id.required' => 'O campo medico_id é obrigatório',
            'medico_id.exists' => 'O medico_id informado não existe',
            'paciente_id.required' => 'O campo paciente_id é obrigatório',
            'paciente_id.exists' => 'O paciente_id informado não existe',
            'data.required' => 'O campo data é obrigatório',
            'data.date' => 'O campo data deve ser uma data válida',
            'data.format' => 'O campo data deve estar no formato Y-m-d H:i:s',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
