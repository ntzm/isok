<?php

declare(strict_types=1);

namespace Ntzm\Isok\Violation;

use Ntzm\Isok\Steps;
use Ntzm\Isok\Rule\Rule;

final class Violation
{
    /** @var Rule */
    private $rule;

    /** @var Steps */
    private $steps;

    /** @var array */
    private $args;

    public function __construct(Rule $rule, Steps $steps, array $args = [])
    {
        $this->rule = $rule;
        $this->steps = $steps;
        $this->args = $args;
    }

    public function rule() : Rule
    {
        return $this->rule;
    }

    public function steps() : Steps
    {
        return $this->steps;
    }

    public function args() : array
    {
        return $this->args;
    }
}
