<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violations;

final class When implements Rule
{
    /** @var Rule[] */
    private array $predicates;

    /** @var Rule[] */
    private array $rules = [];

    public function __construct(Rule ...$predicates)
    {
        $this->predicates = $predicates;
    }

    public function then(Rule ...$rules): self
    {
        $rule        = new self(...$this->predicates);
        $rule->rules = $rules;

        return $rule;
    }

    public function violationsFor($value, Steps $steps): Violations
    {
        if ($this->failsPredicates($value, $steps)) {
            return Violations::none();
        }

        $violations = Violations::none();

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($value, $steps));
        }

        return $violations;
    }

    /** @param mixed $value */
    private function failsPredicates($value, Steps $steps): bool
    {
        $violations = Violations::none();

        foreach ($this->predicates as $predicate) {
            $violations = $violations->withViolations($predicate->violationsFor($value, $steps));
        }

        return $violations->hasSome();
    }
}
