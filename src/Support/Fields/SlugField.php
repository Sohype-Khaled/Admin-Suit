<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\ContainsOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class SlugField extends FieldAbstract
{


    public $target;


    public function setOperators()
    {
        return [
            new ContainsOperator,
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }


    public function target($target)
    {
        $this->target = $target;
        return $this;
    }

}
