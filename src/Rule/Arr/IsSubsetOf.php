<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Arr;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function array_diff;
use function is_array;

final class IsSubsetOf implements Rule
{
    /** @var mixed[] */
    private $allowedValues;

    /** @param mixed ...$allowedValues */
    public function __construct(...$allowedValues)
    {
        $this->allowedValues = $allowedValues;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        if (is_array($value) === false) {
            return new Violations(new Violation('is not a subset of', $this, $path));
        }

        $disallowedValues = array_diff($value, $this->allowedValues);

        if ($disallowedValues === []) {
            return Violations::none();
        }

        return new Violations(new Violation('is not a subset of', $this, $path));
    }
}