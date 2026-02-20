<?php
namespace Modules\Record\Application\UseCases\RecordCategory;

use Modules\Record\Domain\Repositories\RecordCategoryRepositoryInterface;

class GetAllRecordsCategories
{
    public function __construct(
        private RecordCategoryRepositoryInterface $repository
    ) {}

    /**
     * @return array
     */
    public function execute(): array
    {
        return $this->repository->findAll();
    }
}
