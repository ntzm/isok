<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\DateTime;

use DateTimeImmutable;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use Throwable;
use function is_string;

final class IsDateTime implements Rule
{
    /** @var string|null */
    private $format;

    public function __construct(?string $format = null)
    {
        $this->format = $format;
    }

    public function violationsFor($value, Steps $steps) : Violations
    {
        if ($this->isValid($value)) {
            return Violations::none();
        }

        return new Violations(new Violation($this, $steps, ['format' => $this->format]));
    }

    /** @param mixed $value */
    private function isValid($value) : bool
    {
        if (! is_string($value)) {
            return false;
        }

        try {
            if ($this->format === null) {
                new DateTimeImmutable($value);
            } else {
                DateTimeImmutable::createFromFormat($this->format, $value);
            }
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }
}
