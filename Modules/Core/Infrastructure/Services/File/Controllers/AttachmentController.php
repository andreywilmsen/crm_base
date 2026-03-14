<?php

namespace Modules\Core\Infrastructure\Services\File\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Modules\Core\Application\Services\File\UseCases\UploadAttachment;
use Modules\Core\Infrastructure\Services\File\Requests\UploadAttachmentRequest;
use Illuminate\Http\JsonResponse;
use Modules\Core\Application\Services\File\UseCases\DeleteAttachment;
use Modules\Core\Infrastructure\Services\File\Requests\DeleteAttachmentRequest;

class AttachmentController extends Controller
{
    public function __construct(
        private readonly UploadAttachment $uploadAttachmentUseCase,
        private readonly DeleteAttachment $deleteAttachmentUseCase
    ) {}

    public function store(UploadAttachmentRequest $request): JsonResponse
    {
        try {
            $fileEntity = $this->uploadAttachmentUseCase->execute(
                $request->owner_id,
                $request->owner_type,
                $request->file('file'),
                $request->get('folder', 'uploads')
            );

            return response()->json([
                'success' => true,
                'message' => 'Arquivo anexado com sucesso.',
                'data'    => $fileEntity
            ], 201);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(int $id, DeleteAttachmentRequest $request): JsonResponse
    {
        try {
            $success = $this->deleteAttachmentUseCase->execute($id);

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Removido com sucesso.' : 'Falha ao remover arquivo.'
            ]);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
