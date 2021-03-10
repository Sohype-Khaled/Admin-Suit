<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\Operators\ContainsOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;
use Codtail\AdminSuit\Support\FieldAbstract;

class TextField extends FieldAbstract
{

    public $component = 'TextField';

    public function setOperators()
    {
        return [
            new ContainsOperator,
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }

    public $argument_component = [
        'component' => 'input',
        'attrs' => [
            'type' => 'text',
        ]
    ];


}
