<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Length;

use InvalidArgumentException;
use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Util\Length;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

final class HasLengthBetween implements Rule
{
    /** @var int */
    private $min;

    /** @var int */
    private $max;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        if ($this->isValid($value)) {
            return Violations::none();
        }

        return new Violations(new Violation('is not length', $this, $path));
    }

    /** @param mixed $value */
    private function isValid($value) : bool
    {
        try {
            $length = Length::of($value);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        return $length >= $this->min && $length <= $this->max;
    }
}