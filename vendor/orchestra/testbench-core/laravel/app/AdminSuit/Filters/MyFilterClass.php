<?php

namespace App\AdminSuit\Filters;

use Codtail\AdminSuit\Support\Filters\FilterAbstract;

class MyFilterClass extends FilterAbstract
{
    protected function apply($builder)
    {
        // TODO apply filter here
        return $builder;
    }
}