<?php

namespace Modules\Record\Application\UseCases\RecordCategory;

use Modules\Record\Domain\Repositories\RecordCategoryRepositoryInterface;

class DeleteRecordCategory
{
    public function __construct(
        private RecordCategoryRepositoryInterface $repository
    ) {}

    public function execute(int $id): void
    {
        $category = $this->repository->findById($id);

        if ($category) {
            $this->repository->delete($category);
        }
    }
}