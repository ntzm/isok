<?php

declare(strict_types=1);

namespace Ntzm\Isok\Violation;

use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Steps;

final class Violation
{
    /** @var Rule */
    private $rule;

    /** @var Steps */
    private $steps;

    /** @var mixed[] */
    private $args;

    /** @param mixed[] $args */
    public function __construct(Rule $rule, Steps $steps, array $args = [])
    {
        $this->rule  = $rule;
        $this->steps = $steps;
        $this->args  = $args;
    }

    public function rule() : Rule
    {
        return $this->rule;
    }

    public function steps() : Steps
    {
        return $this->steps;
    }

    /** @return mixed[] */
    public function args() : array
    {
        return $this->args;
    }
}
