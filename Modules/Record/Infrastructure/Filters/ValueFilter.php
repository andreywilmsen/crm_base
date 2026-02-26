<?php

namespace Modules\Record\Infrastructure\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Infrastructure\Services\TableHandler\Contracts\BaseFilter;

class ValueFilter extends BaseFilter
{
    protected function requestKey(): string 
    {
        return 'value';
    }

    protected function apply(Builder $query, mixed $value): Builder
    {
        $cleanValue = str_replace(['.', ','], ['', '.'], $value);
        return $query->where('value', 'LIKE', "%{$cleanValue}%");
    }
}