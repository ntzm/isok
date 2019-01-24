<?php

declare(strict_types=1);

namespace Ntzm\Isok;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violations;

final class Validator
{
    /** @var Rule[] */
    private $rules;

    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    /** @param mixed $data */
    public function validate($data) : ValidationResult
    {
        $violations = Violations::none();
        $path       = new Path();

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($data, $path));
        }

        return new ValidationResult($violations);
    }
}
