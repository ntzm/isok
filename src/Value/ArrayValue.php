<?php

declare(strict_types=1);

namespace Ntzm\Isok\Value;

final class ArrayValue implements Value
{
    /** @var string[] */
    private array $path;

    public function __construct(string ...$path)
    {
        $this->path = $path;
    }

    /**
     * @param mixed $rootValue
     *
     * @return mixed
     */
    public function getValueFromRoot($rootValue)
    {
        $carry = $rootValue;

        foreach ($this->path as $key) {
            if (! isset($carry[$key])) {
                return null;
            }

            $carry = $carry[$key];
        }

        return $carry;
    }
}
