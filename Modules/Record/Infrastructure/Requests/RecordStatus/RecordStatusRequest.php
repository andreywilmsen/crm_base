<?php

namespace Modules\Record\Infrastructure\Requests\RecordStatus;

use Illuminate\Foundation\Http\FormRequest;

class RecordStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
        ];
    }
}
