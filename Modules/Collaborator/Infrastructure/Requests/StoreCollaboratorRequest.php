<?php

namespace Modules\Collaborator\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollaboratorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:3|max:255',
            'email'       => 'email|max:255|unique:collaborators,email',
            'phone'       => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'O nome do colaborador é obrigatório.',
            'name.min'          => 'O nome deve ter pelo menos :min caracteres.',
            'email.email'       => 'Informe um endereço de e-mail válido.',
            'email.unique'      => 'Este e-mail já está cadastrado para outro colaborador.',
            'phone.max'         => 'O telefone não pode ultrapassar :max caracteres.',
            'description.max'   => 'A descrição não pode ultrapassar :max caracteres.',
        ];
    }
}
