<?php

declare(strict_types=1);

namespace Ntzm\Isok\Rule\Arr;

use InvalidArgumentException;
use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Violation\Violation;
use Ntzm\Isok\Violation\Violations;
use function array_key_exists;
use function is_array;
use function is_int;
use function is_string;

final class HasKey implements Rule
{
    /** @var int|string */
    private $key;

    /** @var Rule[] */
    private $rules = [];

    /** @param int|string $key */
    public function __construct($key)
    {
        if (! is_int($key) && ! is_string($key)) {
            throw new InvalidArgumentException('Key must be a string or an int');
        }

        $this->key = $key;
    }

    public function that(Rule ...$rules) : self
    {
        $rule        = new self($this->key);
        $rule->rules = $rules;

        return $rule;
    }

    public function violationsFor($value, Path $path) : Violations
    {
        if (! is_array($value) || ! array_key_exists($this->key, $value)) {
            return new Violations(new Violation('does not have key ' . $this->key, $this, $path));
        }

        $violations = Violations::none();
        $path       = $path->down($this->key);

        foreach ($this->rules as $rule) {
            $violations = $violations->withViolations($rule->violationsFor($value[$this->key], $path));
        }

        return $violations;
    }
}
