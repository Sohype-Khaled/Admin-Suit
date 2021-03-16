<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\ContainsOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class FileField extends FieldAbstract
{

    public $type = 'file';

    public $accept;

    public function setOperators()
    {
        return [
            new ContainsOperator,
            new IsEqualToOperator,
            new IsNotEqualToOperator,
        ];
    }

    public function accept(string $types)
    {
        $this->accept = $types;
        return $this;
    }

}
