<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\String;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_string;
use function strcasecmp;
use function strlen;
use function substr;

final class EndsWith implements Rule
{
    /** @var string */
    private $needle;

    public function __construct(string $needle)
    {
        $this->needle = $needle;
    }

    public function violationsFor($value, Steps $steps) : Violations
    {
        if (is_string($value) && $this->endsWith($value)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['needle' => $this->needle]));
    }

    private function endsWith(string $value) : bool
    {
        return strcasecmp(
            substr($value, strlen($value) - strlen($this->needle)),
            $this->needle
        ) === 0;
    }
}
