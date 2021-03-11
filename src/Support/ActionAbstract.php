<?php


namespace Codtail\AdminSuit\Support;


use Illuminate\Database\Eloquent\Model;

abstract class ActionAbstract
{

    public $class_name;

    public $text;

    public $models;

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }
}