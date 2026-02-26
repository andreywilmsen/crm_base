<?php

namespace Modules\Record\Infrastructure\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Infrastructure\Services\TableHandler\Contracts\BaseFilter;

class TitleFilter extends BaseFilter
{
    protected function requestKey(): string 
    {
        return 'title';
    }

    protected function apply(Builder $query, mixed $value): Builder
    {
        return $query->where('title', 'LIKE', "%{$value}%");
    }
}