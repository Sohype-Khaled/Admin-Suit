<?php


namespace Codtail\AdminSuit\Support;


use Illuminate\Support\Str;

abstract class FieldAbstract
{

    public $component;

    public $name;

    public $title;

    public $placeholder;

    public $value;

    public $sortable = false;

    public $related_column;

    public $withLink = false;

    public $required = false;

    public $link;

    public $operators = [];

    public $argument_component;

    public function __construct()
    {
        $this->operators = $this->setOperators();
    }

    abstract public function setOperators();

    public static function make($title, $column_name = '')
    {
        $column_name = Str::snake($column_name ? $column_name : $title);

        return (new static())
            ->setTitle($title)
            ->setName($column_name);
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function sortable()
    {
        $this->sortable = true;
        return $this;
    }

    public function required()
    {
        $this->required = true;
        return $this;
    }

    public function link($to = '')
    {
        $this->withLink = true;
        $this->link = $to;
        return $this;
    }

    public function setArgumentComponent(array $component)
    {
        $this->argument_component = $component;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}