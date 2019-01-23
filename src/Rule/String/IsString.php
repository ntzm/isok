<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\String;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_string;

final class IsString implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if (is_string($value)) {
            return Violations::none();
        }

        return new Violations(new Violation('is not a string', $this, $path));
    }
}
