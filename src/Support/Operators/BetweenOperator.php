<?php


namespace Codtail\AdminSuit\Support\Operators;


use Codtail\AdminSuit\Support\OperatorAbstract;

class BetweenOperator extends OperatorAbstract
{

    public $title = 'Between';

    public $number_of_argument = 2;

    public function apply($builder)
    {
        foreach (request()->input($this->getFilterName()) as $filter) {
            $args = explode(',', $filter['arguments']);
            $builder->whereBetween($filter['field'], $args);
        }
        return $builder;
    }
}