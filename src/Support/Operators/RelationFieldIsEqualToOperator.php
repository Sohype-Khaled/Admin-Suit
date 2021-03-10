<?php


namespace Codtail\AdminSuit\Support\Operators;


use Codtail\AdminSuit\Support\OperatorAbstract;

class RelationFieldIsEqualToOperator extends OperatorAbstract
{

    public $title = 'Is Equal To';


    public function apply($builder)
    {
        dd(request()->input($this->getFilterName()));
//        foreach (request()->input($this->getFilterName()) as $filter)
//            $builder->where($filter['field'], $filter['arguments']);

        return $builder;
    }
}