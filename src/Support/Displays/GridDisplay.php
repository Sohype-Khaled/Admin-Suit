<?php

namespace Codtail\AdminSuit\Support\Displays;


use Codtail\AdminSuit\Support\DisplayAbstract;

class GridDisplay extends DisplayAbstract
{
    public $withPagination = true;

    public $icon = 'fa fa-th';

    public function resolveQuery()
    {
        return $this->builder->paginate($this->per_page)->fragment('per_page');
    }
}