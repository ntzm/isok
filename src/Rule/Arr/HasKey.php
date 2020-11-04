<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Arr;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Step;
use Ntzm\Isok\Steps;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;

use function array_key_exists;
use function is_array;

final class HasKey implements Rule
{
    /** @var int|string */
    private $key;

    /** @var Rule[] */
    private array $rules = [];

    private string $name;

    /** @param int|string $key */
    public function __construct($key, ?string $name = null)
    {
        $this->key  = $key;
        $this->name = $name ?? (string) $key;
    }

    public function that(Rule ...$rules): self
    {
        $rule        = clone $this;
        $rule->rules = $rules;

        return $rule;
    }

    public function violationsFor($value, Steps $steps): Violations
    {
        if (! is_array($value) || ! array_key_exists($this->key, $value)) {
            return new Violations(new Violation($this, $steps, ['key' => $this->key]));
        }

        $violations = Violations::none();
        $steps      = $steps->add(new Step($this->key, $this->name));

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($value[$this->key], $steps));
        }

        return $violations;
    }
}
