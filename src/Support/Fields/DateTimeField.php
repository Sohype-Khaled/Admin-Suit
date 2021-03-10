<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\Operators\BetweenOperator;
use Codtail\AdminSuit\Support\Operators\InOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsGreaterThanOperator;
use Codtail\AdminSuit\Support\Operators\IsGreaterThanOrEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsLessThanOperator;
use Codtail\AdminSuit\Support\Operators\IsLessThanOrEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;
use Codtail\AdminSuit\Support\FieldAbstract;

class DateTimeField extends FieldAbstract
{

    public $component = 'DateTimeField';

    public function __construct()
    {
        parent::__construct();

        $this->argument_component = [
            'component' => 'input',
            'attrs' => [
                'type' => 'date',
                'format' =>  config('admin-suit.date_format')
            ]
        ];
    }

    public function setOperators()
    {
        return [
            new BetweenOperator,
            new IsGreaterThanOrEqualToOperator,
            new IsGreaterThanOperator,
            new IsLessThanOperator,
            new IsLessThanOrEqualToOperator,
            new IsNotEqualToOperator,
            new IsEqualToOperator
        ];
    }


}
