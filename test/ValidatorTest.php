<?php

declare(strict_types=1);

namespace Ntzm\IsokTest;

use Generator;
use Ntzm\Isok\Rule\Arr\HasKey;
use Ntzm\Isok\Rule\Rule;
use Ntzm\Isok\Rule\String\EndsWith;
use Ntzm\Isok\Rule\String\StartsWith;
use Ntzm\Isok\Step;
use Ntzm\Isok\Validator;
use Ntzm\Isok\Violation\Violation;
use PHPUnit\Framework\TestCase;

use function array_map;
use function end;
use function explode;
use function get_class;
use function implode;
use function sprintf;

final class ValidatorTest extends TestCase
{
    /**
     * @param string[] $expectedViolations
     * @param Rule[]   $rules
     * @param mixed    $input
     *
     * @dataProvider provideTestCases
     */
    public function test(array $expectedViolations, array $rules, $input): void
    {
        $validator           = new Validator(...$rules);
        $result              = $validator->validate($input);
        $violations          = $result->violations();
        $formattedViolations = array_map(static function (Violation $violation): string {
            $keySteps = implode('.', array_map(static function (Step $step): string {
                return (string) $step->key();
            }, $violation->steps()->asArray()));

            $nameSteps = implode('.', array_map(static function (Step $step): string {
                return $step->name();
            }, $violation->steps()->asArray()));

            $classParts = explode('\\', get_class($violation->rule()));
            $class      = end($classParts);

            return sprintf('%s (%s): %s', $keySteps, $nameSteps, $class);
        }, $violations->asArray());

        self::assertSame($expectedViolations, $formattedViolations);
    }

    /** @return Generator<string, array{0: string[], 1: Rule[], 2: mixed}> */
    public function provideTestCases(): Generator
    {
        yield 'HasKey root' => [
            [' (): HasKey'],
            [new HasKey('a', 'A')],
            [],
        ];

        yield 'HasKey with' => [
            ['a (A): EndsWith'],
            [(new HasKey('a', 'A'))->that(new EndsWith('foo'))],
            ['a' => 'foobar'],
        ];

        yield 'HasKey nested' => [
            ['a.b.c (A.Bee.Sea): StartsWith'],
            [
                (new HasKey('a', 'A'))->that(
                    (new HasKey('b', 'Bee'))->that(
                        (new HasKey('c', 'Sea'))->that(
                            new StartsWith('foo')
                        )
                    )
                ),
            ],
            [
                'a' => [
                    'b' => ['c' => 'bar'],
                ],
            ],
        ];
    }
}
