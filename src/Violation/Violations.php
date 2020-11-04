<?php

declare(strict_types=1);

namespace Ntzm\Isok\Violation;

use ArrayIterator;
use Countable;
use IteratorAggregate;

use function array_merge;
use function count;

/**
 * @implements IteratorAggregate<int, Violation>
 */
final class Violations implements Countable, IteratorAggregate
{
    /** @var Violation[] */
    private array $items;

    public function __construct(Violation ...$violations)
    {
        $this->items = $violations;
    }

    public static function none(): self
    {
        return new self();
    }

    public function withViolations(Violations $violations): self
    {
        return new self(...array_merge($this->items, $violations->items));
    }

    public function hasNone(): bool
    {
        return $this->items === [];
    }

    public function hasSome(): bool
    {
        return $this->items !== [];
    }

    /** @return Violation[] */
    public function asArray(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /** @return ArrayIterator<int, Violation> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
