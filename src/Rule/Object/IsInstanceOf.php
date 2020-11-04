<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Object;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

use function is_a;

final class IsInstanceOf implements Rule
{
    /** @var class-string */
    private string $class;

    /** @param class-string $class */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function violationsFor($value, Steps $steps): Violations
    {
        if (is_a($value, $this->class, true)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['class' => $this->class]));
    }
}
