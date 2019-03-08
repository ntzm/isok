<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\UUID;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function is_string;
use function preg_match;

final class IsUUIDv5 implements Rule
{
    private const REGEX = '/^[0-9A-F]{8}-[0-9A-F]{4}-5[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    public function violationsFor($value, Path $path) : Violations
    {
        if (is_string($value) &&
            preg_match(self::REGEX, $value) !== false
        ) {
            return Violations::none();
        }

        return new Violations(new Violation('is not a UUID v5', $this, $path));
    }
}