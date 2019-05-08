<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

final class Is implements Rule
{
    /** @var mixed */
    private $expectedValue;

    /** @param mixed $expectedValue */
    public function __construct($expectedValue)
    {
        $this->expectedValue = $expectedValue;
    }

    public function violationsFor($value, Steps $steps) : Violations
    {
        if ($this->expectedValue === $value) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['expectedValue' => $this->expectedValue]));
    }
}
