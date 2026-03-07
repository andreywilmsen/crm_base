<?php

namespace Modules\Record\Application\UseCases\Record;

use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use InvalidArgumentException;
use Modules\Record\Application\DTOs\Record\RecordUpdateDTO;
use Modules\Record\Infrastructure\Mappers\RecordMapper;

class UpdateRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(RecordUpdateDTO $dto): Record
    {
        $existingRecord = $this->recordRepository->findById($dto->id);

        if (!$existingRecord) {
            throw new InvalidArgumentException("Registro com ID {$dto->id} não encontrado.");
        }

        $updatedRecord = RecordMapper::fromDTO($dto);

        return $this->recordRepository->save($updatedRecord);
    }
}
