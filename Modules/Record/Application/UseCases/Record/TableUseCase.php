<?php

namespace Modules\Record\Application\UseCases\Record;

use Modules\Record\Infrastructure\Presenters\TableSchema;
use Modules\Core\Infrastructure\Services\TableHandler\Eloquent\TableGenerator;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use Modules\Record\Infrastructure\Mappers\RecordMapper;

class TableUseCase
{
    public function __construct(
        private RecordRepositoryInterface $repository
    ) {}

    public function getTableData(array $categories, array $status): array
    {
        $columns = TableSchema::getColumns($categories, $status);

        return TableGenerator::generateTable(
            columns: $columns,
            query: $this->repository->getQueryBuilder(),
            mapper: fn($model) => RecordMapper::toResponseDTO($model)
        );
    }
}
