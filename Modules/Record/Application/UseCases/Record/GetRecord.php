<?php

namespace Modules\Record\Application\UseCases\Record;

use InvalidArgumentException;
use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;

class GetRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(int $id): Record
    {
        $record = $this->recordRepository->findById($id);

        if (!$record) {
            throw new InvalidArgumentException('Registro não encontrado.');
        }

        return $record;
    }
}
