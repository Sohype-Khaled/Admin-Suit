<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class SelectField extends FieldAbstract
{

    public $itemText;

    public $itemValue = 'id';

    public $searchable = true;

    public $options = [];

    public function setOperators()
    {
        return [
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }

    public function notSearchable()
    {
        $this->searchable = false;
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

}
