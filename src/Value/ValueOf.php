<?php

namespace Ntzm\Isok\Value;

use Ntzm\Isok\Steps;

final class ValueOf
{
    /** @var mixed */
    private $value;

    /** @var Steps */
    private $steps;

    /** @param mixed $value */
    public function __construct($value, Steps $steps)
    {
        $this->value = $value;
        $this->steps = $steps;
    }

    /** @return mixed */
    public function value()
    {
        if ($this->value instanceof Value) {
            return $this->value->getValueFromRoot($this->steps->rootValue());
        }

        return $this->value;
    }
}