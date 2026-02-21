<?php

namespace Modules\Record\Infrastructure\Requests\RecordCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecordCategoryRequest extends FormRequest
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
