<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Number;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_float;

final class IsFloat implements Rule
{
    public function violationsFor($value, Steps $steps) : Violations
    {
        if (is_float($value)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps));
    }
}
