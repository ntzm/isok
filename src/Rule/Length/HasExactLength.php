<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Length;

use InvalidArgumentException;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Util\Length;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

final class HasExactLength implements Rule
{
    /** @var int */
    private $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function violationsFor($value, Steps $steps) : Violations
    {
        if ($this->isValid($value)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['length' => $this->length]));
    }

    /** @param mixed $value */
    private function isValid($value) : bool
    {
        try {
            $length = Length::of($value);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        return $length === $this->length;
    }
}
