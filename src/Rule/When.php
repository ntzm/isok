<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule;

use Ntzm\Isok\Path;
use Ntzm\Isok\Violation\Violations;

final class When implements Rule
{
    /** @var Rule[] */
    private $predicates;

    /** @var Rule[] */
    private $rules = [];

    public function __construct(Rule ...$predicates)
    {
        $this->predicates = $predicates;
    }

    public function then(Rule ...$rules) : self
    {
        $rule        = new self(...$this->predicates);
        $rule->rules = $rules;

        return $rule;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        $violations = Violations::none();

        if ($this->failsPredicates($value, $path)) {
            return $violations;
        }

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($value, $path));
        }

        return $violations;
    }

    private function failsPredicates($value, Path $path): bool
    {
        $violations = Violations::none();

        foreach ($this->predicates as $predicate) {
            $violations = $violations->withViolations($predicate->violationsFor($value, $path));
        }

        return $violations->hasNone();
    }
}
