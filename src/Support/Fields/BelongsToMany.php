<?php


namespace Codtail\AdminSuit\Support\Fields;

use Codtail\AdminSuit\Support\RelationshipFieldAbstract;

class BelongsToMany extends RelationshipFieldAbstract
{

    public $component = 'BelongsToMany';

    public $fields = ['id'];

    public function setOperators()
    {
        // TODO: Implement setOperators() method.
    }

    public function setFields($array)
    {
        $this->fields = $array;
        return $this;
    }
}