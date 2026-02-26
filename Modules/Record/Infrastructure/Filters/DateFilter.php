<?php

namespace Modules\Record\Infrastructure\Filters;

use Modules\Core\Infrastructure\Services\TableHandler\Contracts\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class DateFilter extends BaseFilter
{
    protected function requestKey(): string
    {
        return 'referenceDate';
    }

    protected function apply(Builder $query, mixed $value): Builder
    {
        return $query->whereDate('reference_date', $value);
    }
}
