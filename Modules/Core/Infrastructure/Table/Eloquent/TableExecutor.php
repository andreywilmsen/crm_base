<?php
namespace Modules\Core\Infrastructure\Table\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class TableExecutor
{
    public function execute(Builder $query, array $filters, int $perPage = 15)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(array_filter($filters))
            ->then(fn($q) => $q->orderBy('id', 'desc')->paginate($perPage));
    }
}