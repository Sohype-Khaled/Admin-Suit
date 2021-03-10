<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\BetweenOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsGreaterThanOperator;
use Codtail\AdminSuit\Support\Operators\IsGreaterThanOrEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsLessThanOperator;
use Codtail\AdminSuit\Support\Operators\IsLessThanOrEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class NumberField extends FieldAbstract
{

    public $component = 'NumberField';

    public function setOperators()
    {
        return [
            new BetweenOperator,
            new IsGreaterThanOrEqualToOperator,
            new IsGreaterThanOperator,
            new IsLessThanOperator,
            new IsLessThanOrEqualToOperator,
            new IsNotEqualToOperator,
            new IsEqualToOperator
        ];
    }

    public $argument_component = [
        'component' => 'input',
        'attrs' => [
            'type' => 'number',
        ]
    ];
}
