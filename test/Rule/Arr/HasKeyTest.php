<?php

declare(strict_types=1);

namespace Ntzm\IsokTest\Rule\Arr;

use Generator;
use InvalidArgumentException;
use Ntzm\Isok\Path;
use Ntzm\Isok\Rule\Arr\HasKey;
use PHPUnit\Framework\TestCase;
use stdClass;

final class HasKeyTest extends TestCase
{
    /**
     * @param mixed $key
     *
     * @dataProvider provideInvalidKeyTypes
     */
    public function testInvalidKeyTypes($key) : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Key must be a string or an int');

        new HasKey($key);
    }

    public function provideInvalidKeyTypes() : Generator
    {
        yield [123.45];
        yield [[]];
        yield [new stdClass()];
        yield [true];
        yield [null];
    }

    public function testHasKey() : void
    {
        $rule = new HasKey('foo');

        self::assertTrue($rule->violationsFor(['foo' => 0], new Path())->hasNone());
    }

    public function testDoesNotHaveKey() : void
    {
        $rule = new HasKey('foo');

        self::assertFalse($rule->violationsFor(['bar' => 0], new Path())->hasNone());
    }
}
