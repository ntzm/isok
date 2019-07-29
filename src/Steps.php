<?php

declare(strict_types=1);

namespace Ntzm\Isok;

use ArrayIterator;
use IteratorAggregate;

final class Steps implements IteratorAggregate
{
    /** @var Step[] */
    private $steps = [];

    /** @var mixed */
    private $rootValue;

    /** @param mixed $rootValue */
    private function __construct($rootValue)
    {
        $this->rootValue = $rootValue;
    }

    /** @param mixed $value */
    public static function root($value) : self
    {
        return new self($value);
    }

    public function add(Step $step) : self
    {
        $steps          = clone $this;
        $steps->steps[] = $step;

        return $steps;
    }

    /** @return mixed */
    public function rootValue()
    {
        return $this->rootValue;
    }

    /** @return Step[] */
    public function asArray() : array
    {
        return $this->steps;
    }

    /**
     * @return       ArrayIterator|Step[]
     *
     * @psalm-return ArrayIterator<int, Step>
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->steps);
    }
}
