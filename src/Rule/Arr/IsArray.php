<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Arr;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_array;

final class IsArray implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if (is_array($value)) {
            return Violations::none();
        }

        return new Violations(new Violation('is not an array', $this, $path));
    }
}
