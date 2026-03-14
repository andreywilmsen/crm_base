<?php

namespace Modules\Core\Application\Services\File\UseCases;

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

        return $this->repository->createAttachment($ownerId, $ownerType, $fileEntity);
    }
}
