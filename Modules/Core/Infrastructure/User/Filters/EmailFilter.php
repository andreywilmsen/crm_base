<?php

namespace Modules\Core\Infrastructure\User\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Infrastructure\Table\Filters\BaseFilter;

class EmailFilter extends BaseFilter
{
    protected function requestKey(): string
    {
        return 'email';
    }

    protected function apply(Builder $query, mixed $value): Builder
    {
        return $query->where('email', 'LIKE', "%{$value}%");
    }
}
