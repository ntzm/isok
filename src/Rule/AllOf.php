<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Path;
use Ntzm\Isok\Violation\Violations;

final class AllOf implements Rule
{
    /** @var Rule[] */
    private $rules;

    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        $violations = Violations::none();

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($value, $path));
        }

        return $violations;
    }
}
