<?php

declare(strict_types=1);

namespace Ntzm\Isok;

use InvalidArgumentException;
use function is_int;
use function is_string;

final class Step
{
    /** @var int|string */
    private $key;

    /** @var string */
    private $name;

    /** @param int|string $key */
    public function __construct($key, string $name)
    {
        if (! is_int($key) && ! is_string($key)) {
            throw new InvalidArgumentException('Key must be a string or an int');
        }

        $this->key  = $key;
        $this->name = $name;
    }

    /** @return int|string */
    public function key()
    {
        return $this->key;
    }

    public function name() : string
    {
        return $this->name;
    }
}
