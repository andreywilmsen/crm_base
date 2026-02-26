<?php

namespace Modules\Core\Infrastructure\Services\TableHandler\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter
{
    protected abstract function requestKey(): string;

    protected abstract function apply(Builder $query, mixed $value): Builder;

    public function handle(Builder $query, Closure $next)
    {
        if (request()->filled($this->requestKey())) {
            $this->apply($query, request($this->requestKey()));
        }

        return $next($query);
    }
}
