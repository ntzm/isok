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
        $this->rules = $rules;

        return $this;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        $violations = Violations::none();

        foreach ($this->predicates as $predicate) {
            $violations->withViolations($predicate->violationsFor($value, $path));
        }

        if ($violations->hasSome()) {
            return $violations;
        }

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($value, $path));
        }

        return $violations;
    }
}
