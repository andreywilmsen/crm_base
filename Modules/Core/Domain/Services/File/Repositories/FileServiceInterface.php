<?php

namespace Modules\Core\Domain\Services\File\Repositories;

use Modules\Core\Domain\Services\File\Domain\File;

interface FileServiceInterface
{
    public function store(mixed $file, string $folder): File;

    public function createAttachment(int $ownerId, string $ownerType, File $file): File;

    public function delete(string $path, string $disk): bool;

    public function deleteAttachment(int $id): void;

    public function findById(int $id): ?File;
}
