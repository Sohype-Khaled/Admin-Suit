<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\ContainsOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class TextareaField extends FieldAbstract
{
    public $noResize = false;

    public $rows = 20;

    public $cols = 20;

    public function setOperators()
    {
        return [
            new ContainsOperator,
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }

    public function noResize($value)
    {
        $this->noResize = $value;
        return $this;
    }


    public function cols($value)
    {
        $this->cols = $value;
        return $this;
    }

    public function rows($value)
    {
        $this->rows = $value;
        return $this;
    }
}
