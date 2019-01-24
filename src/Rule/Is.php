<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Path;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

final class Is implements Rule
{
    /** @var mixed */
    private $value;

    /** @param mixed $value */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        if ($this->value === $value) {
            return Violations::none();
        }

        return new Violations(new Violation('is not the expected value', $this, $path));
    }
}
