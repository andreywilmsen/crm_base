<?php

namespace Modules\Record\Domain\Repositories;

use Modules\Record\Domain\Entities\RecordStatus;

interface RecordStatusRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?RecordStatus;

    public function save(RecordStatus $category): RecordStatus;

    public function delete(RecordStatus $category): void;
}
