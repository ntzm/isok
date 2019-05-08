<?php

declare(strict_types=1);

namespace Ntzm\Isok;

use ArrayIterator;
use IteratorAggregate;

final class Steps implements IteratorAggregate
{
    /** @var Step[] */
    private $steps = [];

    private function __construct()
    {
    }

    public static function root() : self
    {
        return new self();
    }

    public function add(Step $step) : self
    {
        $steps          = clone $this;
        $steps->steps[] = $step;

        return $steps;
    }

    /** @return ArrayIterator|Step[] */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->steps);
    }
}
