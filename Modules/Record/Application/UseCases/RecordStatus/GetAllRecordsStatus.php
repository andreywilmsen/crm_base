<?php
namespace Modules\Record\Application\UseCases\RecordStatus;

use Modules\Record\Domain\Repositories\RecordStatusRepositoryInterface;

class GetAllRecordsStatus
{
    public function __construct(
        private RecordStatusRepositoryInterface $repository
    ) {}

    /**
     * @return array
     */
    public function execute(): array
    {
        return $this->repository->findAll();
    }
}
