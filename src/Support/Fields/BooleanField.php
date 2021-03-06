<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\InOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class BooleanField extends FieldAbstract
{

    public $type = 'checkbox';

    public $class = 'form-check-input';

    public function setOperators()
    {
        return [
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }


}
