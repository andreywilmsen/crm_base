<?php

namespace Modules\Core\Infrastructure\Services\File\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Core\Application\Services\File\UseCases\UploadAttachment;
use Modules\Core\Infrastructure\Services\File\Requests\UploadAttachmentRequest;
use Modules\Core\Application\Services\File\UseCases\DeleteAttachment;
use Modules\Core\Infrastructure\Services\File\Requests\DeleteAttachmentRequest;
use Modules\Core\Infrastructure\Traits\HandlesErrors;

class AttachmentController extends Controller
{
    use HandlesErrors;

    public function __construct(
        private readonly UploadAttachment $uploadAttachmentUseCase,
        private readonly DeleteAttachment $deleteAttachmentUseCase
    ) {}

    /**
     * @param UploadAttachmentRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(UploadAttachmentRequest $request): JsonResponse|RedirectResponse
    {
        $folder = "uploads/{$request->owner_type}/{$request->owner_id}";

        try {
            $fileEntity = $this->uploadAttachmentUseCase->execute(
                $request->owner_id,
                $request->owner_type,
                $request->file('file'),
                $folder
            );

            if (!$request->expectsJson()) {
                return redirect()->back()->with('success', 'Arquivo anexado com sucesso.');
            }

            return response()->json([
                'success' => true,
                'message' => 'Arquivo anexado com sucesso.',
                'data'    => $fileEntity
            ], 201);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param DeleteAttachmentRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(int $id, DeleteAttachmentRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $success = $this->deleteAttachmentUseCase->execute($id);

            if (!$request->expectsJson()) {
                return redirect()->back()->with('success', 'Arquivo removido com sucesso.');
            }

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Removido com sucesso.' : 'Falha ao remover arquivo.'
            ]);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
