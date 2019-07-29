<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Step;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

final class Each implements Rule
{
    /** @var Rule[] */
    private $rules;

    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    public function violationsFor($value, Steps $steps): Violations
    {
        if (! is_iterable($value)) {
            return new Violations(new Violation($this, $steps));
        }

        $violations = Violations::none();

        foreach ($value as $key => $innerValue) {
            $innerSteps = $steps->add(new Step($key, $key));

            foreach ($this->rules as $rule) {
                $violations = $violations->withViolations($rule->violationsFor($innerValue, $innerSteps));
            }
        }

        return $violations;
    }
}
