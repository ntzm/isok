<?php

declare(strict_types=1);

namespace Ntzm\Isok;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use function is_int;
use function is_string;

final class Path implements IteratorAggregate
{
    /** @var (int|string)[] */
    private $route = [];

    /** @param int|string $key */
    public function down($key) : self
    {
        if (is_int($key) === false && is_string($key) === false) {
            throw new InvalidArgumentException('Key must be a string or an int');
        }

        $path          = clone $this;
        $path->route[] = $key;

        return $path;
    }

    /** @return ArrayIterator|(int|string)[] */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->route);
    }
}
