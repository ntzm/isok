<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Bool;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

final class IsTrue implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if ($value === true) {
            return Violations::none();
        }

        return new Violations(new Violation('is not true', $this, $path));
    }
}
