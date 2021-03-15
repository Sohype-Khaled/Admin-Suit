<?php


namespace Codtail\AdminSuit\Support;


use Illuminate\Support\Str;

abstract class FieldAbstract
{

    public $name;

    public $label;

    public $placeholder;

    public $value;

    public $required = false;

    public $type;


    public $sortable = false;

    public $withLink = false;

    public $link;

    public $operators = [];

//    public $argument_component;

    public function __construct()
    {
        $this->operators = $this->setOperators();
    }

    abstract public function setOperators();

    public static function make($label, $name = '')
    {
        $name = Str::snake($name ? $name : $label);

        return (new static())->label($label)->name($name);
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function label($label)
    {
        $this->label = $label;
        return $this;
    }


    public function required()
    {
        $this->required = true;
        return $this;
    }


    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }


    public function value($value)
    {
        $this->value = $value;
        return $this;
    }


    public function link($to = '')
    {
        $this->withLink = true;
        $this->link = $to;
        return $this;
    }


    public function sortable()
    {
        $this->sortable = true;
        return $this;
    }

    public function setArgumentComponent(array $component)
    {
        $this->argument_component = $component;
        return $this;
    }
}