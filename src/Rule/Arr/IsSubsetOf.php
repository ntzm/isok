<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Arr;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function array_diff;
use function is_array;

final class IsSubsetOf implements Rule
{
    /** @var mixed[] */
    private $allowedValues;

    /** @param mixed ...$allowedValues */
    public function __construct(...$allowedValues)
    {
        $this->allowedValues = $allowedValues;
    }

    public function violationsFor($value, Steps $steps) : Violations
    {
        if ($this->isValid($value)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['allowedValues' => $this->allowedValues]));
    }

    /** @param mixed $value */
    private function isValid($value) : bool
    {
        if (! is_array($value)) {
            return false;
        }

        $disallowedValues = array_diff($value, $this->allowedValues);

        return $disallowedValues === [];
    }
}
