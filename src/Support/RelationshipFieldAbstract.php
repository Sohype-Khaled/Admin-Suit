<?php


namespace Codtail\AdminSuit\Support;


use Illuminate\Support\Str;

abstract class RelationshipFieldAbstract extends FieldAbstract
{
    public $relationship = true;

    public $model;

    public $related_column;

    public static function make($title, $column_name = '', $model = '')
    {
        $column_name = Str::camel($column_name ? $column_name : $title);

        return (new static())
            ->setTitle($title)
            ->setName($column_name)
            ->setModel($model)
            ->setRelatedColumn();
    }


    public function setRelatedColumn($related_column = 'id')
    {
        $this->related_column = $related_column;
        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
}