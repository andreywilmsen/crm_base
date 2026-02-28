<?php

namespace Modules\Core\Infrastructure\User\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Infrastructure\Table\Filters\BaseFilter;

class NameFilter extends BaseFilter
{
    protected function requestKey(): string
    {
        return 'name';
    }

    protected function apply(Builder $query, mixed $value): Builder
    {
        return $query->where('name', 'LIKE', "%{$value}%");
    }
}
