<?php

namespace Modules\Record\Application\UseCases\RecordStatus;

use Modules\Record\Domain\Repositories\RecordStatusRepositoryInterface;

class DeleteRecordStatus
{
    public function __construct(
        private RecordStatusRepositoryInterface $repository
    ) {}

    public function execute(int $id): void
    {
        $category = $this->repository->findById($id);

        if ($category) {
            $this->repository->delete($category);
        }
    }
}
