<?php

declare(strict_types=1);

namespace Ntzm\Isok\Value;

interface Value
{
    /**
     * @param mixed $rootValue
     *
     * @return mixed
     */
    public function getValueFromRoot($rootValue);
}
