<?php


namespace Codtail\AdminSuit\Support;


use Closure;
use Illuminate\Support\Str;

abstract class FilterAbstract
{

    public $name;

    public function handle($payload, Closure $next)
    {
        if (!request()->has($this->getFilterName()))
            return $next($payload);

        $builder = $next($payload);

        return $this->apply($builder);
    }

    public function getFilterName()
    {
        return Str::snake($this->name ?? explode('Filter', class_basename($this))[0]);
    }

    abstract protected function apply($builder);
}