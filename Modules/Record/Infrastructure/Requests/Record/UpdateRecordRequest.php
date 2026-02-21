<?php

namespace Modules\Record\Infrastructure\Requests\Record;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|min:3|max:255',
            'reference_date' => 'required|date',
            'value'          => 'nullable|numeric|min:0',
            'description'    => 'required|string|max:1000',
            'status_id'      => 'required|integer',
            'category_id'    => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'          => 'O campo título é obrigatório.',
            'title.string'            => 'O título deve ser um texto válido.',
            'title.min'               => 'O título deve ter pelo menos :min caracteres.',
            'title.max'               => 'O título não pode ultrapassar :max caracteres.',
            'reference_date.required' => 'A data de referência é obrigatória.',
            'reference_date.date'     => 'Informe uma data válida.',
            'value.numeric'           => 'O valor deve ser um número.',
            'value.min'               => 'Valores negativos não são permitidos.',
            'description.required'    => 'A descrição é obrigatória.',
            'description.string'      => 'A descrição deve ser um texto.',
            'description.max'         => 'A descrição não pode ultrapassar :max caracteres.',
            'status_id.required'      => 'O campo status é obrigatório.',
            'status_id.integer'       => 'O status informado é inválido.',
            'category_id.required'    => 'O campo categoria é obrigatório.',
        ];
    }
}
