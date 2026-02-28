<?php
namespace Modules\Core\Infrastructure\Table\Filters;

use Illuminate\Database\Eloquent\Builder;
use Closure;

abstract class BaseFilter
{
    abstract protected function requestKey(): string;
    abstract protected function apply(Builder $query, mixed $value): Builder;

    public function handle(Builder $query, Closure $next)
    {
        $value = request($this->requestKey());

        if (is_null($value) || $value === '') {
            return $next($query);
        }

        $query = $this->apply($query, $value);

        return $next($query);
    }
}