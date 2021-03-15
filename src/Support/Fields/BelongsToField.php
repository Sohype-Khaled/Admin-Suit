<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;
use Codtail\AdminSuit\Support\Operators\RelationFieldIsEqualToOperator;
use Codtail\AdminSuit\Support\RelationshipFieldAbstract;
use Codtail\AdminSuit\Support\FieldAbstract;

class BelongsToField extends FieldAbstract
{

    public $fields = [];

    public function setOperators()
    {
        return [
            new RelationFieldIsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }


    public function fields($array)
    {
        $this->fields = $array;
        return $this;
    }
}
