<?php

namespace Codtail\AdminSuit\Support\Displays;


use Codtail\AdminSuit\Support\DisplayAbstract;

class TableDisplay extends DisplayAbstract
{
    public $withPagination = true;

    public $icon = 'fa fa-table';

    public function resolveQuery()
    {
        return $this->builder->paginate($this->per_page)->fragment('per_page');
    }
}