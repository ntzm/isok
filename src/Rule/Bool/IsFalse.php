<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Bool;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

final class IsFalse implements Rule
{
    public function violationsFor($value, Steps $steps) : Violations
    {
        if ($value === false) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps));
    }
}
