<?php
namespace Modules\Record\Application\UseCases\RecordCategory;

use Modules\Record\Domain\Entities\RecordCategory;
use Modules\Record\Domain\Repositories\RecordCategoryRepositoryInterface;

class GetRecordCategory
{
    public function __construct(
        private RecordCategoryRepositoryInterface $repository
    ) {}

    public function execute(int $id): ?RecordCategory
    {
        return $this->repository->findById($id);
    }
}
