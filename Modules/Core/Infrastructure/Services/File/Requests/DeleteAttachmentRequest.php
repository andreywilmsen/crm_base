<?php

namespace Modules\Core\Infrastructure\Services\File\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Infrastructure\Services\File\Persistence\Eloquent\AttachmentModel;

class DeleteAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $attachment = AttachmentModel::find($this->route('id'));
        return $attachment && (int) $attachment->user_id === (int) auth()->id();
    }

    public function rules(): array
    {
        return [];
    }
}
