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

final class ValidatorTest extends TestCase
{
    /**
     * @dataProvider provideTestCases
     * @param string[] $expectedViolations
     * @param Rule[]   $rules
     * @param mixed    $input
     */
    public function test(array $expectedViolations, array $rules, $input) : void
    {
        $validator = new Validator(...$rules);
        $result = $validator->validate($input);
        $this->assertTrue($result->fails());
        $violations = $result->violations();
        $formattedViolations = array_map(static function (Violation $violation) : string {
            $keySteps = implode('.', array_map(static function (Step $step) : string {
                return $step->key();
            }, $violation->steps()->asArray()));

            $nameSteps = implode('.', array_map(static function (Step $step) : string {
                return $step->name();
            }, $violation->steps()->asArray()));

            $classParts = explode('\\', get_class($violation->rule()));
            $class = end($classParts);

            return "{$keySteps} ({$nameSteps}): {$class}";
        }, $violations->asArray());

        $this->assertSame($expectedViolations, $formattedViolations);
    }

    public function provideTestCases() : Generator
    {
        yield 'HasKey root' => [
            [
                ' (): HasKey',
            ],
            [
                new HasKey('a', 'A')
            ],
            [],
        ];

        yield 'HasKey with' => [
            [
                'a (A): EndsWith',
            ],
            [
                (new HasKey('a', 'A'))->that(new EndsWith('foo')),
            ],
            [
                'a' => 'foobar',
            ],
        ];

        yield 'HasKey nested' => [
            [
                'a.b.c (A.Bee.Sea): StartsWith',
            ],
            [
                (new HasKey('a', 'A'))->that(
                    (new HasKey('b', 'Bee'))->that(
                        (new HasKey('c', 'Sea'))->that(
                            new StartsWith('foo')
                        )
                    )
                )
            ],
            [
                'a' => [
                    'b' => [
                        'c' => 'bar',
                    ],
                ],
            ],
        ];
    }
}
