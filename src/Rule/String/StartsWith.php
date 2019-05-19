<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\String;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_string;
use function strpos;

final class StartsWith implements Rule
{
    /** @var string */
    private $needle;

    public function __construct(string $needle)
    {
        $this->needle = $needle;
    }

    public function violationsFor($value, Steps $steps) : Violations
    {
        if (is_string($value) && $this->startsWith($value)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['needle' => $this->needle]));
    }

    private function startsWith(string $value) : bool
    {
        return strpos($value, $this->needle) === 0;
    }
}
