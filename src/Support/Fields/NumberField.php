<?php


namespace Codtail\AdminSuit\Support\Fields;


use Codtail\AdminSuit\Support\FieldAbstract;
use Codtail\AdminSuit\Support\Operators\BetweenOperator;
use Codtail\AdminSuit\Support\Operators\IsEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsGreaterThanOperator;
use Codtail\AdminSuit\Support\Operators\IsGreaterThanOrEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsLessThanOperator;
use Codtail\AdminSuit\Support\Operators\IsLessThanOrEqualToOperator;
use Codtail\AdminSuit\Support\Operators\IsNotEqualToOperator;

class NumberField extends FieldAbstract
{
    public $type = 'number';

    public $min;

    public $max;

    public $step = 1;

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

    /**
     * @param mixed $min
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @param mixed $max
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @param int $step
     */
    public function setStep(int $step)
    {
        $this->step = $step;
        return $this;
    }

}
