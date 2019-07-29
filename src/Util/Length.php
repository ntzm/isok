<?php

declare(strict_types=1);

namespace Ntzm\Isok\Util;

use InvalidArgumentException;
use RuntimeException;
use function count;
use function is_countable;
use function is_float;
use function is_int;
use function is_string;
use function mb_detect_encoding;
use function mb_strlen;

final class Length
{
    /** @param mixed $value */
    public static function of($value) : int
    {
        if (is_int($value) || is_float($value)) {
            $value = (string) $value;
        }

        if (is_string($value)) {
            $encoding = mb_detect_encoding($value);

            if ($encoding === false) {
                throw new InvalidArgumentException('Cannot detect encoding');
            }

            $length = mb_strlen($value, $encoding);

            if ($length === false) {
                throw new RuntimeException('Detected encoding ' . $encoding . ' is invalid');
            }

            return $length;
        }

        if (is_countable($value)) {
            return count($value);
        }

        throw new InvalidArgumentException('Must be an int, float, string or countable');
    }
}
