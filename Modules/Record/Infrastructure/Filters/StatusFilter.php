<?php

namespace Modules\Record\Infrastructure\Filters;

use Modules\Core\Infrastructure\Table\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends BaseFilter
{
    protected function requestKey(): string
    {
        return 'statusName';
    }

    protected function apply(Builder $query, mixed $value): Builder
    {
        return $query->whereHas('status', function ($q) use ($value) {
            $q->where('name', $value);
        });
    }
}
