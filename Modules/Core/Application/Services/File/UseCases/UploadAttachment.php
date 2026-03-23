<?php

namespace Modules\Core\Application\Services\File\UseCases;

use Illuminate\Support\Facades\Log;
use Modules\Core\Domain\Services\File\Repositories\FileServiceInterface;

class UploadAttachment
{
    public function __construct(public readonly FileServiceInterface $repository) {}

    public function execute(int $ownerId, string $ownerType, mixed $file)
    {
        $folder = "uploads/{$ownerType}/{$ownerId}";

        $fileEntity = $this->repository->store($file, $folder);

        try {
            return $this->repository->createAttachment($ownerId, $ownerType, $fileEntity);
        } catch (\Exception $e) {
            try {
                $this->repository->delete($fileEntity->path, $fileEntity->disk);
            } catch (\Exception $e) {
                Log::warning("Não foi possível remover arquivo após falha no banco: " . $fileEntity->path);
            }
            throw $e;
        }
    }
}
