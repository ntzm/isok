<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violations;

// TODO: Is this class useful?
final class AllOf implements Rule
{
    /** @var Rule[] */
    private array $rules;

    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    public function violationsFor($value, Steps $steps): Violations
    {
        $violations = Violations::none();

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($value, $steps));
        }

        return $violations;
    }
}
