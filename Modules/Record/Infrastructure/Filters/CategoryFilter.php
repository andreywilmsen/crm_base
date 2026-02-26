<?php

namespace Modules\Record\Infrastructure\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Infrastructure\Services\TableHandler\Contracts\BaseFilter;

class CategoryFilter extends BaseFilter
{
    protected function requestKey(): string
    {
        return 'categoryName';
    }

    protected function apply(Builder $query, mixed $value): Builder
    {
        return $query->whereHas('category', function ($q) use ($value) {
            $q->where('name', 'LIKE', "%{$value}%");
        });
    }
}
