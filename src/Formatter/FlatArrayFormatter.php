<?php

declare(strict_types=1);

namespace Ntzm\Isok\Formatter;

use Ntzm\Isok\Violation\Violations;
use function implode;
use function iterator_to_array;

final class FlatArrayFormatter
{
    /** @return array<string, array<int, string>> */
    public function format(Violations $violations) : array
    {
        $result = [];

        foreach ($violations as $violation) {
            $key = implode('.', iterator_to_array($violation->path()));

            $result[$key][] = $violation->reason();
        }

        return $result;
    }
}
