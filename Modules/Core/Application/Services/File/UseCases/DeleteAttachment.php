<?php

namespace Modules\Core\Application\Services\File\UseCases;

use Modules\Core\Domain\Services\File\Repositories\FileServiceInterface;

class DeleteAttachment
{

    public readonly FileServiceInterface $repository;

    public function __construct(FileServiceInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $file = $this->repository->findById($id);

        if (!$file) {
            return false;
        }

        $isDeleted = $this->repository->delete($file->path, $file->disk);

        if ($isDeleted) {
            $this->repository->deleteAttachment($id);
            return true;
        }

        return false;
    }
}
