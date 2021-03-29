<?php

namespace Codtail\AdminSuit\Support\Displays;


use Codtail\AdminSuit\Support\DisplayAbstract;

class NestedSetDisplay extends DisplayAbstract
{

    public $icon = 'fa fa-bars';

    public function resolveQuery()
    {
        return $this->builder->defaultOrder()->get()->toTree();
    }
}