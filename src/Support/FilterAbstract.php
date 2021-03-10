<?php


namespace Codtail\AdminSuit\Support;


use Closure;
use Illuminate\Support\Str;

abstract class FilterAbstract
{

    public function handle($payload, Closure $next)
    {
        if (!request()->has($this->getFilterName()))
            return $next($payload);

        $builder = $next($payload);

        return  $this->apply($builder);
    }

    public function getFilterName()
    {
        return Str::snake(class_basename($this));
    }

    abstract protected function apply($builder);
}