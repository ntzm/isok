<?php

declare(strict_types=1);

namespace Ntzm\Isok\Translator;

use Ntzm\Isok\Violation\Violation;

interface Translator
{
    public function translate(Violation $violation): string;
}
