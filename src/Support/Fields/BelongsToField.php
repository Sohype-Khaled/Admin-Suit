<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;
use Codtail\AdminSuit\Support\Operators\RelationFieldIsEqualToOperator;

class BelongsToField extends FieldAbstract
{

    public $fields = [];

    public $model = [];

    public $itemText;

    public $itemValue = 'id';

    public $foreignKey;

    public $nameColumn;

    public $searchable = true;

    public $options = [];

    public $loadOptionsFrom;

    public $relationshipField = true;

    public function setOperators()
    {
        return [
            new RelationFieldIsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }


    public function notSearchable()
    {
        $this->searchable = false;
        return $this;
    }

    public function fields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function model($value)
    {
        $this->model = $value;
        return $this;
    }

    public function itemText($item_text)
    {
        $this->itemText = $item_text;
        return $this;
    }

    public function itemValue($item_value)
    {
        $this->itemValue = $item_value;
        return $this;
    }

    public function options($options)
    {
        $this->options = $options;
        return $this;
    }

    public function foreignKey($foreign_key)
    {
        $this->foreignKey = $foreign_key;
        return $this;
    }

    public function nameColumn($name = 'name')
    {
        $this->nameColumn = $name;
        return $this;
    }

    public function loadOptionsFrom($field)
    {
        $this->loadOptionsFrom = $field;
        return $this;
    }
}
