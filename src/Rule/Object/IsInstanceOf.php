<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Object;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_a;

final class IsInstanceOf implements Rule
{
    /** @var string */
    private $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        if (is_a($value, $this->class)) {
            return Violations::none();
        }

        return new Violations(new Violation('is not an instance of ' . $this->class, $this, $path));
    }
}
