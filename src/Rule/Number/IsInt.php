<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Number;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_int;

final class IsInt implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if (is_int($value)) {
            return Violations::none();
        }

        return new Violations(new Violation('is not an integer', $this, $path));
    }
}