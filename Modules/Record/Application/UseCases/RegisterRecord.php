<?php

namespace Modules\Record\Application\UseCases;

use Modules\Record\Application\DTOs\RecordCreateDTO;
use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;

class RegisterRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(RecordCreateDTO $dto): Record
    {
        $record = new Record(
            id: null,
            title: $dto->title,
            referenceDate: $dto->referenceDate,
            value: $dto->value,
            description: $dto->description,
            status: $dto->status,
            userId: $dto->userId
        );

        return $this->recordRepository->save($record);
    }
}
