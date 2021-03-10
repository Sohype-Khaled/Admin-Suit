<?php


namespace Codtail\AdminSuit\Support\Operators;


use Codtail\AdminSuit\Support\OperatorAbstract;

class IsLessThanOrEqualToOperator extends OperatorAbstract
{

    public $title = 'Is Less Than Or Equal To';

    public function apply($builder)
    {
        foreach (request()->input($this->getFilterName()) as $filter)
            $builder->where($filter['field'], '<=', $filter['arguments']);

        return $builder;
    }
}