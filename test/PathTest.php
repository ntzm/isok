<?php

declare(strict_types=1);

namespace Ntzm\IsokTest;

use Generator;
use InvalidArgumentException;
use Ntzm\Isok\Path;
use PHPUnit\Framework\TestCase;
use stdClass;
use function iterator_to_array;

final class PathTest extends TestCase
{
    /**
     * @param mixed $value
     *
     * @dataProvider provideInvalidTypes
     */
    public function testInvalidTypes($value) : void
    {
        $path = new Path();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Key must be a string or an int');

        $path->down($value);
    }

    public function provideInvalidTypes() : Generator
    {
        yield [123.45];
        yield [[]];
        yield [new stdClass()];
        yield [true];
        yield [null];
    }

    public function testDownString() : void
    {
        $path = new Path();

        $path = $path->down('foo');

        self::assertSame(['foo'], iterator_to_array($path));
    }

    public function testDownInt() : void
    {
        $path = new Path();

        $path = $path->down(0);

        self::assertSame([0], iterator_to_array($path));
    }

    public function testIsImmutable() : void
    {
        $path = new Path();

        $newPath = $path->down('foo');

        self::assertSame([], iterator_to_array($path));
        self::assertSame(['foo'], iterator_to_array($newPath));
    }
}
