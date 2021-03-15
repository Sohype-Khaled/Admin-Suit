<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;
use Codtail\AdminSuit\Support\Operators\RelationFieldIsEqualToOperator;
use Codtail\AdminSuit\Support\RelationshipFieldAbstract;

class BelongsToField extends RelationshipFieldAbstract
{

    public $component = 'BelongsToField';

    public $fields = ['id'];

    public function setOperators()
    {
        return [
            new RelationFieldIsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }

    public function setArgumentAttributes($attrs)
    {
        $this->setArgumentComponent([
            'component' => 'lv-select',
            'attrs' => array_merge($attrs, [
                'ajax' => true
            ])
        ]);
        return $this;
    }

    public function setFields($array)
    {
        $this->fields = $array;
        return $this;
    }
}
