<?php

namespace Modules\Record\Application\UseCases\RecordStatus;

use InvalidArgumentException;
use Modules\Record\Application\DTOs\RecordStatus\RecordStatusDTO;
use Modules\Record\Domain\Entities\RecordStatus;
use Modules\Record\Domain\Repositories\RecordStatusRepositoryInterface;

class UpdateRecordStatus
{
    public function __construct(private RecordStatusRepositoryInterface $repository) {}

    public function execute(RecordStatusDTO $dto): RecordStatus
    {
        $existingStatus = $this->repository->findById($dto->id);

        if (!$existingStatus) {
            throw new InvalidArgumentException("Status com ID {$dto->id} não encontrado.");
        }

        $status = new RecordStatus(
            id: $dto->id,
            name: $dto->name
        );

        return $this->repository->save($status);
    }
}
