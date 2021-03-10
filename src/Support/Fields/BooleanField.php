<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\InOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class BooleanField extends FieldAbstract
{

    public $component = 'BooleanField';

    public $argument_component = [
        'component' => 'lv-select',
        'attrs' => [
            'item_text' => 'text',
            'item_value' => 'value'
        ]
    ];

    public $options = [
        ['text' => 'True', 'value' => 1],
        ['text' => 'False', 'value' => 0],
    ];

    public function setOperators()
    {
        return [
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }


}
