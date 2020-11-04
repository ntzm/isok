<?php

declare(strict_types=1);

namespace Ntzm\Isok\Violation;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;

final class Violation
{
    private Rule $rule;
    private Steps $steps;

    /** @var mixed[] */
    private array $args;

    /** @param mixed[] $args */
    public function __construct(Rule $rule, Steps $steps, array $args = [])
    {
        $this->rule  = $rule;
        $this->steps = $steps;
        $this->args  = $args;
    }

    public function rule(): Rule
    {
        return $this->rule;
    }

    public function steps(): Steps
    {
        return $this->steps;
    }

    /** @return mixed[] */
    public function args(): array
    {
        return $this->args;
    }
}
