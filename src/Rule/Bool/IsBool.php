<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Bool;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_bool;

final class IsBool implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if (is_bool($value)) {
            return Violations::none();
        }

        return new Violations(new Violation('is not a boolean', $this, $path));
    }
}