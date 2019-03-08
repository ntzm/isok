<?php

declare(strict_types=1);

namespace Ntzm\Isok\Formatter;

use Ntzm\Isok\Violation\Violations;

final class FlatArrayFormatter
{
    /** @return string[] */
    public function format(Violations $violations) : array
    {
        $result = [];

        foreach ($violations as $violation) {
            $result[] = $violation->reason();
        }

        return $result;
    }
}
