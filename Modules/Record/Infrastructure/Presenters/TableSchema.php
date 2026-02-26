<?php

namespace Modules\Record\Infrastructure\Presenters;

use Modules\Core\Infrastructure\Services\TableHandler\DTO\TableColumn;
use Modules\Record\Infrastructure\Filters\TitleFilter;
use Modules\Record\Infrastructure\Filters\CategoryFilter;
use Modules\Record\Infrastructure\Filters\DateFilter;
use Modules\Record\Infrastructure\Filters\ValueFilter;
use Modules\Record\Infrastructure\Filters\StatusFilter;

class TableSchema
{
    public static function getColumns($categories = [], $status = []): array
    {
        return [
            new TableColumn(
                name: 'id',
                label: '#',
                type: 'text',
            ),
            new TableColumn(
                name: 'title',
                label: 'Título',
                type: 'text',
                filterClass: TitleFilter::class
            ),
            new TableColumn(
                name: 'categoryName',
                label: 'Categoria',
                type: 'select',
                options: collect($categories)->mapWithKeys(fn($i) => [$i->getName() => $i->getName()])->toArray(),
                filterClass: CategoryFilter::class
            ),
            new TableColumn(
                name: 'referenceDate',
                label: 'Data Ref.',
                type: 'date',
                filterClass: DateFilter::class
            ),
            new TableColumn(
                name: 'value',
                label: 'Valor',
                type: 'text',
                filterClass: ValueFilter::class
            ),
            new TableColumn(
                name: 'statusName',
                label: 'Status',
                type: 'select',
                options: collect($status)->mapWithKeys(fn($i) => [$i->getName() => $i->getName()])->toArray(),
                filterClass: StatusFilter::class
            ),
        ];
    }
}
