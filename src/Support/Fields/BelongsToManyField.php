<?php


namespace Codtail\AdminSuit\Support\Fields;

use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\RelationshipFieldAbstract;

class BelongsToManyField extends FieldAbstract
{


    public $fields = [];

    public $value = [];

    public function setOperators()
    {
        // TODO: Implement setOperators() method.
    }

    public function prepareFields()
    {

    }


    public function fields(\Closure $callback)
    {
        $this->fields = array_map(function ($field) {
            return [
                'component' => (new \ReflectionClass($field))->getShortName(),
                'attrs' => $this->getFieldAttrs(clone $field),
                'operators' => $field->operators
            ];
        }, call_user_func($callback));

        return $this;
    }

    public function getFieldAttrs($field)
    {
        unset($field->operators);
        return $field;
    }
}