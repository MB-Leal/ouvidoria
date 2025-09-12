<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemandaRequest extends FormRequest
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
            'nome'      => 'nullable|string|max:255',
            'email'     => 'nullable|email|max:255',
            'telefone'  => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'mensagem'  => 'required|string|min:10',
            'tipo_id'   => 'required|exists:tipos_demanda,id',
        ];
    }
    public function messages(): array
    {
        return [
            'mensagem.required' => 'O campo de mensagem é obrigatório.',
            'mensagem.min'      => 'A mensagem deve ter no mínimo 10 caracteres.',
            'tipo_id.required'  => 'O tipo de demanda é obrigatório.',
            'tipo_id.exists'    => 'O tipo de demanda selecionado não é válido.',
            'email.email'       => 'O endereço de e-mail não é válido.',
        ];
    }
}
