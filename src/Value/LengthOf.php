<?php

declare(strict_types=1);

namespace Ntzm\Isok\Value;

use InvalidArgumentException;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Util\Length;

final class LengthOf
{
    private Value $value;
    private Steps $steps;

    public function __construct(Value $value, Steps $steps)
    {
        $this->value = $value;
        $this->steps = $steps;
    }

    public function value(): int
    {
        $value = $this->value->getValueFromRoot($this->steps->rootValue());

        try {
            return Length::of($value);
        } catch (InvalidArgumentException $e) {
            return 0;
        }
    }
}
