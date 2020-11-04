<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violations;

interface Rule
{
    /** @param mixed $value */
    public function violationsFor($value, Steps $steps): Violations;
}
