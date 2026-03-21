<?php

namespace Modules\Core\Application\Services\File\UseCases;

use Illuminate\Support\Facades\Log;
use Modules\Core\Domain\Services\File\Repositories\FileServiceInterface;

class UploadAttachment
{
    public readonly FileServiceInterface $repository;

    public function __construct(FileServiceInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $ownerId, string $ownerType, mixed $file, string $folder)
    {
        $fileEntity = $this->repository->store($file, $folder);
        try {
            return $this->repository->createAttachment($ownerId, $ownerType, $fileEntity);
        } catch (\Exception $e) {
            try {
                $this->repository->delete($fileEntity->path, $fileEntity->disk);
            } catch (\Exception $e) {
                Log::warning("Não foi possível remover arquivo órfão após falha no banco: " . $fileEntity->path);
            }
            throw $e;
        }
    }
}
