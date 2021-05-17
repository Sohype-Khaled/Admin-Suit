<?php


namespace Codtail\AdminSuit\Support;


use Codtail\AdminSuit\Support\Fields\BelongsToField;
use Codtail\AdminSuit\Support\Fields\BelongsToManyField;

class BaseForm
{

    public $model;

    public $fields = [];

    protected $instance;

    public function __construct($instance = null)
    {
        $this->prepareFields();

        if ($instance) {
            $this->instance = $instance;
            $this->setFieldValues();
        }

    }

    public function prepareFields()
    {
        $this->fields = array_map(function ($field) {
            return [
                'component' => (new \ReflectionClass($field))->getShortName(),
                'attrs' => $this->getFieldAttrs(clone $field),
                'operators' => $field->operators
            ];
        }, $this->setFields());
    }

    public function getFieldAttrs($field)
    {
        unset($field->operators);
        return $field;
    }

    public function setFields()
    {
        $this->fields = [];
    }

    public function setFieldValues()
    {

        $fields = [];
        foreach ($this->fields as $field) {
            if (is_a($field['attrs'], BelongsToField::class))
                $field['attrs'] = $field['attrs']->value($this->instance->{$field['attrs']->foreignKey});

            if (is_a($field['attrs'], BelongsToManyField::class)) {
                $pivot = $this->instance->{$field['attrs']->name}->map(fn($attribute) => $attribute->pivot);
                $field['attrs'] = $field['attrs']->value($pivot);
            } else
                $field['attrs'] = $field['attrs']->value($this->instance->{$field['attrs']->name});

            $fields[] = $field;
        }


        $this->fields = $fields;

    }
}