<?php

declare(strict_types=1);

namespace Ntzm\Isok\Violation;

use ArrayIterator;
use IteratorAggregate;
use function array_merge;

final class Violations implements IteratorAggregate
{
    /** @var Violation[] */
    private $items;

    public function __construct(Violation ...$violations)
    {
        $this->items = $violations;
    }

    public static function none() : self
    {
        return new self();
    }

    public function withViolations(Violations $violations) : self
    {
        return new self(...array_merge($this->items, $violations->items));
    }

    public function hasNone() : bool
    {
        return $this->items === [];
    }

    public function hasSome() : bool
    {
        return $this->items !== [];
    }

    /** @return ArrayIterator|Violation[] */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}