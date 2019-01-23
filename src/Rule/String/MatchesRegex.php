<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\String;

use InvalidArgumentException;
use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_string;
use function preg_match;

final class MatchesRegex implements Rule
{
    /** @var string */
    private $pattern;

    public function __construct(string $pattern)
    {
        if (preg_match($pattern, '') === false) {
            throw new InvalidArgumentException("[{$pattern}] is not a valid regex pattern");
        }

        $this->pattern = $pattern;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        if (is_string($value) && preg_match($this->pattern, $value) === 1) {
            return Violations::none();
        }

        return new Violations(new Violation('does not match regex ' . $this->pattern, $this, $path));
    }
}
