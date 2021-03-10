<?php


namespace Codtail\AdminSuit\Support\Operators;


use Codtail\AdminSuit\Support\OperatorAbstract;

class ContainsOperator extends OperatorAbstract
{

    public $title = 'Contains';

    public function apply($builder)
    {
        foreach (request()->input($this->getFilterName()) as $filter) {
            $argument = $filter['arguments'];
            $builder->where($filter['field'], 'LIKE', "%$argument%");
        }
        return $builder;
    }
}