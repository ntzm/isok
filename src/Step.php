<?php

declare(strict_types=1);

namespace Ntzm\Isok;

final class Step
{
    /** @var int|string */
    private $key;

    /** @var string */
    private $name;

    /** @param int|string $key */
    public function __construct($key, string $name)
    {
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
