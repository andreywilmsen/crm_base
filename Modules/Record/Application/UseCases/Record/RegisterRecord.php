<?php

namespace Modules\Record\Application\UseCases\Record;

use Modules\Record\Application\DTOs\Record\RecordCreateDTO;
use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;

class RegisterRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(RecordCreateDTO $dto): Record
    {

        $record = new Record(
            title: $dto->title,
            referenceDate: $dto->referenceDate,
            value: $dto->value,
            description: $dto->description,
            statusId: $dto->statusId,
            userId: $dto->userId,
            categoryId: $dto->categoryId,
            id: null
        );

        return $this->recordRepository->save($record);
    }
}
