<?php

declare(strict_types=1);

namespace Ntzm\Isok\Violation;

use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Rule;

final class Violation
{
    /** @var string */
    private $reason;

    /** @var Rule */
    private $rule;

    /** @var Path */
    private $path;

    public function __construct(string $reason, Rule $rule, Path $path)
    {
        $this->reason = $reason;
        $this->rule   = $rule;
        $this->path   = $path;
    }

    public function reason() : string
    {
        return $this->reason;
    }

    public function rule() : Rule
    {
        return $this->rule;
    }

    public function path() : Path
    {
        return $this->path;
    }
}
