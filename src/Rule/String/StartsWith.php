<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\String;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Value\Value;
use Ntzm\Isok\Value\ValueOf;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

use function is_string;
use function strpos;

final class StartsWith implements Rule
{
    /** @var string|Value */
    private $needle;

    /** @param string|Value $needle */
    public function __construct($needle)
    {
        $this->needle = $needle;
    }

    public function violationsFor($value, Steps $steps): Violations
    {
        $needle = (new ValueOf($this->needle, $steps))->value();

        if (is_string($needle) && is_string($value) && $this->startsWith($value, $needle)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['needle' => $needle]));
    }

    private function startsWith(string $value, string $needle): bool
    {
        return strpos($value, $needle) === 0;
    }
}
