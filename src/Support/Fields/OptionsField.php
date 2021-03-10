<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class OptionsField extends FieldAbstract
{

    public $component = 'OptionsField';

    public $type = 'lv-select';

    public $options = [];

    public $argument_component = [
        'component' => 'lv-select',
        'attrs' => [
            'item_text' => 'text',
            'item_value' => 'value'
        ]
    ];

    public function setOperators()
    {
        return [
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }



}
