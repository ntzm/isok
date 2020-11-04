<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Net;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

use function filter_var;

use const FILTER_VALIDATE_MAC;

final class IsMacAddress implements Rule
{
    public function violationsFor($value, Steps $steps): Violations
    {
        if (filter_var($value, FILTER_VALIDATE_MAC) !== false) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps));
    }
}
