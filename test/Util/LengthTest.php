<?php

declare(strict_types=1);

namespace Ntzm\IsokTest\Util;

use Countable;
use Generator;
use InvalidArgumentException;
use Ntzm\Isok\Util\Length;
use PHPUnit\Framework\TestCase;

final class LengthTest extends TestCase
{
    /**
     * @param mixed $value
     *
     * @dataProvider provideValidOfCases
     */
    public function testValidOf(int $expected, $value) : void
    {
        self::assertSame($expected, Length::of($value));
    }

    public function provideValidOfCases() : Generator
    {
        yield 'empty array' => [0, []];
        yield 'non-empty array' => [1, ['']];

        $countable = new class implements Countable {
            public function count() : int
            {
                return 5;
            }
        };

        yield 'countable' => [5, $countable];
        yield 'empty string' => [0, ''];
        yield 'non-empty string' => [1, 'f'];
        yield 'string with UTF-8' => [1, 'à'];
    }

    /**
     * @param mixed $value
     *
     * @dataProvider provideNonStringOrCountableOfCases
     */
    public function testNonStringOrCountableOf($value) : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be a string or countable');

        Length::of($value);
    }

    public function provideNonStringOrCountableOfCases() : Generator
    {
        yield 'int' => [1];
        yield 'float' => [1.1];

        $nonCountable = new class {
        };

        yield 'non countable object' => [$nonCountable];
    }

    public function testOfWithInvalidEncoding() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot detect encoding');

        Length::of("\xfc\xa1\xa1\xa1\xa1\xa1");
    }
}
