<?php


namespace Codtail\AdminSuit\Support\Operators;


use Codtail\AdminSuit\Support\OperatorAbstract;

class IsNotEqualToOperator extends OperatorAbstract
{

    public $title = 'Is Not Equal To';

    public function apply($builder)
    {
        foreach (request()->input($this->getFilterName()) as $filter)
            $builder->where($filter['field'], '!=', $filter['arguments']);

        return $builder;
    }
}