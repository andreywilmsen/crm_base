<?php

namespace Modules\Record\Application\UseCases;

use Modules\Record\Application\DTOs\RecordUpdateDTO;
use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use InvalidArgumentException;

class UpdateRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(RecordUpdateDTO $dto): Record
    {
        $existingRecord = $this->recordRepository->findById($dto->id);

        if (!$existingRecord) {
            throw new InvalidArgumentException("Registro com ID {$dto->id} não encontrado.");
        }

        $updatedRecord = new Record(
            title: $dto->title,
            referenceDate: $dto->referenceDate,
            value: $dto->value,
            description: $dto->description,
            status: $dto->status,
            userId: $dto->userId,
            id: $dto->id
        );
        return $this->recordRepository->save($updatedRecord);
    }
}
