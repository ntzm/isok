<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Net;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use const FILTER_VALIDATE_URL;
use function filter_var;

final class IsUrl implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if (filter_var($value, FILTER_VALIDATE_URL) !== false) {
            return Violations::none();
        }

        return new Violations(new Violation('is not a URL', $this, $path));
    }
}
