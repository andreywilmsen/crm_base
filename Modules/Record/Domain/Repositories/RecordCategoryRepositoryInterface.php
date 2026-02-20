<?php

namespace Modules\Record\Domain\Repositories;

use Modules\Record\Domain\Entities\RecordCategory;

interface RecordCategoryRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?RecordCategory;

    public function save(RecordCategory $category): RecordCategory;

    public function delete(RecordCategory $category): void;
}