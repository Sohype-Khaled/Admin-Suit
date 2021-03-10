<?php


namespace Codtail\AdminSuit\Support;


use Illuminate\Support\Str;

abstract class OperatorAbstract extends FilterAbstract
{

    public $title;

    public $name;

    public $number_of_argument = 1;

    public function __construct()
    {
        $this->name = $this->getFilterName();
    }

    public function getFilterName()
    {
        return Str::snake(explode('Operator', class_basename($this))[0]);
    }

    abstract public function apply($builder);

    public function setNumberOfArguments($number)
    {
        $this->number_of_argument = $number;
        return $this;
    }
}