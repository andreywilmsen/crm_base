<?php
namespace Modules\Core\Domain\Table\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Closure;

interface FilterInterface
{
    public function handle(Builder $query, Closure $next);
}