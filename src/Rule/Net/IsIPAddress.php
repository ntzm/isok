<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Net;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use const FILTER_VALIDATE_IP;
use function filter_var;

final class IsIPAddress implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if (filter_var($value, FILTER_VALIDATE_IP) !== false) {
            return Violations::none();
        }

        return new Violations(new Violation('is not an IP address', $this, $path));
    }
}
