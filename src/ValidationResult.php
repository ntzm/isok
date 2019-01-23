<?php

declare(strict_types=1);

namespace Ntzm\Isok;

use Ntzm\Isok\Violation\Violations;

final class ValidationResult
{
    /** @var Violations */
    private $violations;

    public function __construct(Violations $violations)
    {
        $this->violations = $violations;
    }

    public function passes() : bool
    {
        return $this->violations->hasNone();
    }

    public function fails() : bool
    {
        return ! $this->passes();
    }

    public function violations() : Violations
    {
        return $this->violations;
    }
}
