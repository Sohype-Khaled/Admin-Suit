<?php


namespace Codtail\AdminSuit\Support\Filters;

use Codtail\AdminSuit\Support\FilterAbstract;
use Closure;

class QFilter extends FilterAbstract
{

    public function handle($payload, Closure $next)
    {
        if (!request()->has($this->getFilterName()))
            return $next($payload::query());

        $builder = $next($payload);

        return  $this->apply($builder);
    }

    protected function apply($builder)
    {
        return $builder::search(request('q'));
    }
}