<?php


namespace Codtail\AdminSuit\Support\Scopes;


use Closure;

class DefaultScope
{
    public $title = 'All Records';

    public $name;

    public function handle($payload, Closure $next)
    {
        return $next($payload);
    }
}