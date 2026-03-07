<?php

namespace Modules\Record\Application\UseCases\Record;

use Modules\Record\Application\DTOs\Record\RecordCreateDTO;
use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use Modules\Record\Infrastructure\Mappers\RecordMapper;

class RegisterRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(RecordCreateDTO $dto): Record
    {

        $record = RecordMapper::fromDTO($dto);

        return $this->recordRepository->save($record);
    }
}
