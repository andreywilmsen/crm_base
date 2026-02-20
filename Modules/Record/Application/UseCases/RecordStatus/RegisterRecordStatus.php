<?php

namespace Modules\Record\Application\UseCases\RecordStatus;

use Modules\Record\Application\DTOs\RecordStatus\RecordStatusDTO;

use Modules\Record\Domain\Entities\RecordStatus;
use Modules\Record\Domain\Repositories\RecordStatusRepositoryInterface;

class RegisterRecordStatus
{
    public function __construct(private RecordStatusRepositoryInterface $repository) {}

    public function execute(RecordStatusDTO $dto): RecordStatus
    {
        $category = new RecordStatus(
            id: $dto->id,
            name: $dto->name
        );

        return $this->repository->save($category);
    }
}
