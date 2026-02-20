<?php
namespace Modules\Record\Application\UseCases\RecordStatus;

use Modules\Record\Domain\Entities\RecordStatus;
use Modules\Record\Domain\Repositories\RecordStatusRepositoryInterface;

class GetRecordStatus
{
    public function __construct(
        private RecordStatusRepositoryInterface $repository
    ) {}

    public function execute(int $id): ?RecordStatus
    {
        return $this->repository->findById($id);
    }
}
