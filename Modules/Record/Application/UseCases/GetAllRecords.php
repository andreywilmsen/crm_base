<?php

namespace Modules\Record\Application\UseCases;

use Modules\Record\Domain\Repositories\RecordRepositoryInterface;

class GetAllRecords
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(): array
    {
        return $this->recordRepository->findAll();
    }
}
