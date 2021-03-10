<?php


namespace Codtail\AdminSuit\Support\Operators;


use Codtail\AdminSuit\Support\OperatorAbstract;

class IsLessThanOperator extends OperatorAbstract
{

    public $title = 'Is Less Than';

    public function apply($builder)
    {
        foreach (request()->input($this->getFilterName()) as $filter)
            $builder->where($filter['field'], '<', $filter['arguments']);

        return $builder;
    }
}