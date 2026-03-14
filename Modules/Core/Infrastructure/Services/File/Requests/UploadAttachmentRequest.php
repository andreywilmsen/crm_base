<?php

namespace Modules\Core\Infrastructure\Services\File\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,docx,doc,zip,xlsx|max:20480',
            'folder' => 'nullable|string|max:50',
            'owner_id'   => 'required|integer|min:1',
            'owner_type' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required'       => 'É necessário selecionar um arquivo para upload.',
            'file.file'           => 'O envio deve ser um arquivo válido.',
            'file.mimes'          => 'O formato do arquivo não é permitido (Aceitos: PDF, Imagens, Office, ZIP).',
            'file.max'            => 'O arquivo é muito grande. O limite é de 20MB.',
            'owner_id.required'   => 'O identificador do proprietário é obrigatório.',
            'owner_id.numeric'    => 'O identificador do proprietário deve ser um número.',
            'owner_type.required' => 'O tipo do proprietário deve ser informado.',
        ];
    }
}
