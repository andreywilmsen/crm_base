<?php
namespace Modules\Core\Application\Table\UseCases;

use Modules\Core\Infrastructure\Table\Eloquent\TableExecutor;
use Illuminate\Database\Eloquent\Builder;

class TableUseCase
{
    public function __construct(private TableExecutor $executor) {}

    public function make(Builder $query, array $columns, array $filters, int $perPage = 15): array
    {
        return [
            'columns' => $columns,
            'records' => $this->executor->execute($query, $filters, $perPage)
        ];
    }
}