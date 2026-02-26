<?php

namespace Modules\Core\Infrastructure\Services\TableHandler\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class TableGenerator
{
    public static function apply(Builder $query, array $criteria): Builder
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(array_filter($criteria))
            ->then(fn($builder) => $builder);
    }

    public static function generateTable(array $columns, Builder $query, callable $mapper, int $perPage = 15): array
    {
        // 1. Resolve os filtros
        $filterClasses = collect($columns)->pluck('filterClass')->filter()->toArray();
        $filteredQuery = self::apply($query, $filterClasses);

        $paginator = $filteredQuery->orderBy('id', 'desc')->paginate($perPage);

        // O setCollection substitui os itens originais pelos DTOs mapeados
        $paginator->setCollection(
            $paginator->getCollection()->map($mapper)
        );

        return [
            'columns' => $columns,
            'records' => $paginator // 'records' contém os links de página e metadados
        ];
    }
}
